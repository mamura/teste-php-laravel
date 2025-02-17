![Logo AI Solutions](http://aisolutions.tec.br/wp-content/uploads/sites/2/2019/04/logo.png)

# AI Solutions

## Teste para novos candidatos (PHP/Laravel)

### Introdução

Este teste utiliza PHP 8.1, Laravel 10 e um banco de dados SQLite simples.

1. Faça o clone desse repositório;
1. Execute o `composer install`;
1. Crie e ajuste o `.env` conforme necessário
1. Execute as migrations e os seeders;

### Primeira Tarefa:

Crítica das Migrations e Seeders: Aponte problemas, se houver, e solucione; Implemente melhorias;

### Segunda Tarefa:

Crie a estrutura completa de uma tela que permita adicionar a importação do arquivo `storage/data/2023-03-28.json`, para a tabela `documents`. onde cada registro representado neste arquivo seja adicionado a uma fila para importação.

Feito isso crie uma tela com um botão simples que dispara o processamento desta fila.

Utilize os padrões que preferir para as tarefas.

### Terceira Tarefa:

Crie um test unitário que valide o tamanho máximo do campo conteúdo.

Crie um test unitário que valide a seguinte regra:

Se a categoria for "Remessa" o título do registro deve conter a palavra "semestre", caso contrário deve emitir um erro de registro inválido.
Se a caterogia for "Remessa Parcial", o titulo deve conter o nome de um mês(Janeiro, Fevereiro, etc), caso contrário deve emitir um erro de registro inválido.


Boa sorte!

# Mamura

## Sugestão de melhoria nas Migrations

### tabela documents
- Por padrão, o tipo do campo category_id será BIGINT. Mas como o id da tabela categories é definido com id(), o Laravel define o tipo como BIGINT UNSIGNED. No entanto, o campo category_id não tem essa definição explícita, o que pode gerar problemas dependendo do banco de dados. Para evitar esse tipo de problema, é interessante definir explicitamente o tipo como unsignedBigInteger

- Embora a chave estrangeira crie um índice automaticamente, pode ser interessante adicionar um índice explícito para a coluna category_id, caso tenhamos consultas frequentes filtrando ou buscando por essa coluna.

### tabela categories
- Defini a coluna name como única (unique) para garantir que nãotenhamos categorias com nomes repetidos.

### Execução das Migrations
- Ao executar as migrations nos deparamos com um erro. Pelo que eu analisei, foi feito um dump no schema no sqlite. Para rodar as migrations precisei renomear esse arquivo de dump