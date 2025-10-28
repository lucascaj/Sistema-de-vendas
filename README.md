
# Sistema de vendas

Se trata de um projeto pessoal, que consiste em um sistema de vendas com divisão de cargos(Operador, Gerente e Diretor). Foi criado com o objetivo de aprender mais sobre PHP, MySQL, segurança etc. Pode ser testado em https://sistemadevendas.free.nf/index.php, com diferentes cargos a partir dessas contas:

<div align="center">

|   Cargo  |     Login     |  Senha |
| -------- | ------------- | ------ |
| Operador | visitante_op  |  1234  |
| Gerente  | visitante_ger |  1234  |
| Diretor  | visitante_dir |  1234  |

</div><br><br/>

Abaixo se encontra a página de login, e depois de logar, o painel reunindo todos os recursos, que estão todos liberados por estar no acesso de diretor:<br><br/>

<img width="1920" height="919" alt="sistemadevendas free nf_index php" src="https://github.com/user-attachments/assets/87dae866-8144-46aa-ab61-3e87398372a0" />

<img width="1920" height="919" alt="sistemadevendas free nf_painel php" src="https://github.com/user-attachments/assets/ff14fdc6-3776-4dce-b673-5a1dc82630ff" />

<br><br/>

### Página de vendas

Essa é a página ao qual simula uma venda, sendo acessível para todos os cargos, com o preenchimento de informações como: Código da venda, data, unidade da loja que ocorreu a venda, produto, quantidade; como mostra abaixo:<br><br/>

<img width="1920" height="919" alt="sistemadevendas free nf_sistema_vendas php" src="https://github.com/user-attachments/assets/61c8cebc-d19e-4793-9b6e-897f1282f4c1" />

<br><br/>

### Gerenciamento de produtos

Nessa página, de acesso apenas para diretores e gerentes, é possível observar a lista de produtos, aos quais podem ser removidos ou editados, seja o nome ou o valor unitário, além de que também é possível acrescentar mais produtos:<br><br/>

<img width="1920" height="919" alt="sistemadevendas free nf_addremprodutos php" src="https://github.com/user-attachments/assets/1693cbb7-02d3-4a83-b6bb-b1a8f5c00b69" />

<br><br/>

### Gerenciamento de funcionários

Aqui, é possível ter o retorno da lista de funcionário, com a sua função, sendo possível editar o nome e a função, sendo uma página de acesso apenas para diretores e gerentes. A remoção e cadastramento de um funcionário só é liberada para diretores. Além disso, se houver mais de um diretor, esse diretor não consegue alterar nada relacionado ao outro diretor. A remoção de diretores, se dá via banco de dados, por ser uma função menos rotativa e por questões de segurança. Na primeira imagem é possível ver o acesso de um diretor, e na segunda, o de um gerente:<br><br/>

<img width="1920" height="919" alt="sistemadevendas free nf_cargos php" src="https://github.com/user-attachments/assets/e08b6e7a-5d22-4629-aacb-97a5d6ec37ba" />

<img width="1920" height="919" alt="sistemadevendas free nf_cargos php (1)" src="https://github.com/user-attachments/assets/eb848ab6-60a2-4352-8840-cce691c5924a" /><br><br/>

É possível filtrar por nome ou por cargo como mostra abaixo:<br><br/>

<div align="center">

<img width="711" height="403" alt="image" src="https://github.com/user-attachments/assets/df48e558-f8da-459a-ac2f-bc8ed92b6aa2"/>

<img width="711" height="403" alt="image" src="https://github.com/user-attachments/assets/0b99263f-bdd8-4870-b293-452b72193bd2"/>

</div>

<br><br/>

### Histórico de vendas

Nessa página, temos o histórico de vendas que é acessado somente pelo diretor, mostrando as informações pertinentes de cada venda, e retornando o lucro bruto de todas as vendas.<br><br/>

<img width="1920" height="919" alt="sistemadevendas free nf_relatorio php" src="https://github.com/user-attachments/assets/39ead26c-8ea1-42ae-9325-8aa62f02fcc7" /><br><br/>

É possível filtrar as vendas por código da venda, data, loja, produto ou valor total como mostra abaixo:<br><br/>

<div align="center">

<img width="951" height="259" alt="image" src="https://github.com/user-attachments/assets/f2e84f4c-b8d0-418b-99eb-c38fb71048e2" />

</div>
