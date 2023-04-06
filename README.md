# CodeToCloudWoot


<h4 align="center"> 
	🚧 Experimente agora mesmo nosso sistema de gerenciamento de sessões do WhatsApp, apis e integração ao Chatwoot! Desenvolvido em PHP, nosso software é a solução perfeita para gerenciar suas conversas no WhatsApp com eficiência e praticidade. E o melhor de tudo: temos uma versão grátis para que você possa integrar ao chatwoot! 🚀🚧
</h4>

## Descrição do Projeto
<p align="center">Transforme a gestão de sessões e APIs em uma tarefa fácil com nossa implementação baseada em CodeCHAT, uma plataforma ágil e confiável construída sobre o Baileys. Gerencie sessões e usuários, dispare mensagens em massa (na versão paga), converta o Chatwoot em um modelo SaaS (na versão paga) e ainda explore a implementação de chatBOT com ferramentas como o DialogFlow.</p>

### CRÉDITOS/AGRADECIMENTOS

- Cleber Dev do Codechat :) https://github.com/code-chat-br/whatsapp-api
- ....

### Em Construção

- [x] Configurações Iniciais [27/02/2022];
- [x] Adição de Sessões e Pareamento;
- [x] Criação de usuários
- [ ] Envio de Mensagens (API EXTERNA)
- [ ] Envio de áudio, arquivo, imagem (API EXTERNA)
- [ ] Envio de link (API EXTERNA)
- [ ] Envio de localização GPS (API EXTERNA)
- [ ] Envio de sticks (API EXTERNA)
- [ ] Envio de Botões (API EXTERNA)
- [ ] Adição de usuários e APIs para acesso externo
- [x] Modo Chatwoot SaaS (versão Paga)
- [x] Integração ao Asaas (versão Paga)
- [x] Chamadas Restfull
- [x] Integração com o Chatwoot "Texto, Audio,Video, Image, Documento 100%! (Utilizando o Cloud liberando assim as pesquisas de satisfação por exemplo)


### Pré-requisitos

O nosso sistema foi testado em ambientes Linux e Windows, e é compatível tanto com o servidor web Apache como com o NGINX. É importante ressaltar que é obrigatório ter o PHP na versão 8.0 ou superior. Versões anteriores, como o PHP 7.4, podem apresentar problemas de funcionamento.

Além disso, é necessário que o PHP esteja com as extensões mbstring, openssl ou mcrypt e intl instaladas. Caso contrário, o sistema pode não funcionar corretamente.

O nosso banco de dados foi desenvolvido utilizando o MySQL 8. Caso prefira utilizar o MariaDB ou o MySQL 5 ou 6, é possível adaptá-lo apenas alterando o COLLATE e importando o banco.

Collate do MySQL8 > utf8mb4
Collate <MySQL6 > utf8

um jeito rápido de alterar o colate é abrir o banco de dados e substituir no arquivo para uft8 antes de importar o mesmo.


<br>
É NECESSÁRIO O COMPOSER!
### 🎲 renomeie o arquivo /config/.env.example para /config/.env em seguida edite o mesmo:
```bash
Edite aonde tem:
APP_NAME="NOME DE SUA PREFERENCIA MEU.CHATWOOT.APP"
HOSTNAMEDEFAULT="URL DESTE SISTEMA HTTP://MEUSISTEMA.COM" SEM O / NO FINAL
API_KEY_WHATS="A CHAVE API DO CODECHAT"
FULL_HOST_WHATS="O HOST DE ONDE ESTÁ O CODECHAT EXEMPLO: HTTP://127.0.0.1:44490" SEM O / NO FINAL
API_KEY_CHATWOOT="CHAVE API DO CHATWOOT OBS: É A CHAVE GERAL GERADA NO /SUPER_ADMIN"
FULL_HOST_CHATWOOT="AONDE ESTÁ INSTALADO O CHATWOOT EXEMPLO HTTP://APP.MEUCHATWOOT.COM" SEM O / NO FINAL
DATABASE_URL="BANCO DE DADOS FORMATO: mysql://root:password@localhost/mdpainel"
```
### 🎲  COPIE O ARQUIVO ENV.YML PARA DENTRO DA PASTA SRC DO SEU CODECHAT "FAÇA BACKUP!!!" E EDITE O MESMO
```bash
# Procure por WEBHOOK: E ALTERE PARA AONDE ESTÁ INSTALADO ESTE SISTEMA COM O FINAL /TOCHATWOOT EXEMPLO:
 URL: https://meusistema.com/tochatwoot
 #CASO QUEIRA EDITAR MAIS COISAS, FIQUE A VONTADE, POREM NÃO EDITE AONDE TÁ EXPLICITO PARA NÃO EDITAR SOB O RISCO DE PERDER O FUNCIONAMENTO
E NÃO ALTERE A AUTENTICAÇÃO APIKEY PARA JWT
```

### 🎲 POR FIM NO CHATWOOT VÁ NO ARQUIVO .ENV PROCURE POR WHATSAPP_CLOUD_BASE_URL CASO NÃO TENHA, NO FINAL DO ARQUIVO ADICIONE O MESMO:

```bash
WHATSAPP_CLOUD_BASE_URL=https://meusistema.com   # NOVAMENTE SEM O / NO FINAL,  SALVE E SAIA DO ARQUIVO
#REINICIE O CHATWOOT
sudo cwctl -r
```
Importe o banco de dados no MySQL;
Dentro da Pasta DATABASE

o usuário de acesso é: superadmin
a senha de acesso é: admin

Altere posteriormente  a senha!

Mais informações sobre o sistema de usuários pode ser encontrado aqui!
https://github.com/CakeDC/users/blob/11.next-cake4/Docs/Home.md
inclusive, pode ser habilitado até login com redes sociais e afins, bem completinho :)

# Pronto, só correr para o abraço

#Olá :)

### Autor
---

<a href="https://mdbr.tech/">
 <img style="border-radius: 50%;" src="https://avatars.githubusercontent.com/u/21254630?v=4" width="100px;" alt=""/>
 <br />
 <sub><b>Marcos Antonio ou Tonhão</b></sub></a> <a href="https://mdbr.tech" title="Voialá">🚀</a>


Feito com ❤️ por SirTonhão 👋🏽 Entre em contato!

[![Linkedin Badge](https://img.shields.io/badge/-Tony-blue?style=flat-square&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/marcosasneves/)](https://www.linkedin.com/in/marcosasneves/) 
[![Hotmail Badge](https://img.shields.io/badge/-otherside540n@hotmail.com-c14438?style=flat-square&logo=Hotmail&logoColor=white&link=mailto:otherside540n@hotmail.com)](mailto:otherside540n@hotmail.com)
