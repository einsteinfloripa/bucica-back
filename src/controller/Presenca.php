<?php
require_once "./src/model/aluno.php";
require_once "./src/model/sala.php";
require_once "./src/model/presenca.php";
require_once "./src/model/email.php";
require_once "./src/api/google_calendar.php";

function registrarPresenca($req)
{
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            try {
                //Verifica variáveis obrigatórias
                if (!$req["Cpf"])
                    return array(400, "CPF Não informado");
                    
                //Sanitiza variáveis
                $Cpf = filter_var(preg_replace( '/[^0-9]/is', '', $req["Cpf"] ), FILTER_SANITIZE_NUMBER_INT);

                //Valida entradas
                if (!validaCPF($Cpf)) 
                    return array(400, "CPF inválido");
                
                $Aluno = getAlunoByCpf($Cpf);

                if (!$Aluno) 
                    return array(400, "Aluno não registrado na base");

                $DiaDaSemana = date("l");
                if (in_array($DiaDaSemana, array("Saturday", "Sunday")))
                    return array(400, "Não tem aula hoje");

                $Hora = date("H");
                $Minuto = date("i");

                if ($Hora >= 22) {
                    return array(400, "Não tem mais aula hoje"); 
                } else if ($Hora >= 20 && $Minuto >=15) {
                    //Segundo Bloco
                    if ($Hora == 20 && $Minuto < 20) 
                        return array(400, "Aguarde até 20h20"); 
                    
                        if (getPresencaByDatetimeAndAluno(date("Y-m-d "). "20:20:00",date("Y-m-d "). "22:00:00", $Aluno["Id"])) {
                            //Já tem presença
                            return array(202, array("Url" => "https://meet.google.com/" . getSalaByDiaAndBlocoAndTurma(date("Y-m-d "), 2, $Aluno["Turma"])["Meet"]));
                        }

                    if ($Hora == 20 && $Minuto <= 40) {
                        $Atrasado = false;
                    } else {
                        $Atrasado = true;
                    }
                    $Bloco = 2;
                } else {
                    //Primeiro Bloco
                    if ($Hora < 17 || ($Hora == 17 && $Minuto < 50)) 
                        return array(400, "Aguarde até 17h50");

                        if (getPresencaByDatetimeAndAluno(date("Y-m-d "). "17:50:00",date("Y-m-d "). "20:15:00", $Aluno["Id"])) {
                            //Já tem presença
                            return array(202, array("Url" => "https://meet.google.com/" . getSalaByDiaAndBlocoAndTurma(date("Y-m-d "), 1, $Aluno["Turma"])["Meet"]));
                        }
                    
                    if ($Hora == 17 || ($Hora == 18 && $Minuto <= 10)) {
                        $Atrasado = false;
                    } else {
                        $Atrasado = true;
                    }
                    $Bloco = 1;
                }

                $Sala = getSalaByDiaAndBlocoAndTurma(date("Y-m-d "), $Bloco, $Aluno["Turma"]);
                $Attendees = getEmailsByIdAluno($Aluno["Id"]);

                if (!$Sala) {
                    //Se meet não existe cria um novo
                    $Event = insertEvent($Attendees);
                    createSala($Event['Meet'], $Event['Id'], $Bloco, $Aluno["Turma"]);  
                    $Meet = $Event['Meet'];
                } else {
                    //Se meet já existe adiciona email do aluno                
                    $Meet = $Sala["Meet"];
                    $Google_id = $Sala["Google_id"];

                    $OldAttendees = getEvent($Google_id)["Attendees"];

                    patchEvent($Google_id, array_merge($OldAttendees, $Attendees));
                }

                if (!createPresenca($Aluno["Id"], (int)$Atrasado))
                    return array(500, "Não foi possível registrar presença");


                return array(201, array("Url" =>"https://meet.google.com/" . $Meet));


            } catch (Exception $e) {
                return array(500, "Erro interno do servidor");
            }
            break;
        default:
            return array(405, "Método inválido");
            break;
    }
}