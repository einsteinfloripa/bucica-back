# Bucica Backend

Back do Protocolo B.U.C.I.C.A (Banco Unificado de Chamadas Interativas para Controle Automatizado). Responsável pela integração com o Google API e persistência dos dados

---

1 - Crie arquivo .env com as suas varáveis de ambiente

2 - instale dependências:

    composer install

3 - Rode:

    php -S 127.0.0.1:8000

## **POST** _/join_ | *{"Cpf": "999.999.999-99" }*

| 201                             | 202                                      |
| ------------------------------- | ---------------------------------------- |
| Presença Registrada com sucesso | Presença Já foi registrada anteriormente |

> *{"Msg": {"Url": "https://meet.google.com/XXX-XXXX-XXX"} }*

---

| 400             | 404             | 405             | 500          |
| --------------- | --------------- | ------------ | ------------ |
| Dados inválidos | Página não encontrada | Método inválido | Erro Interno |

> *{"Err": "Descrição do Erro" }*
