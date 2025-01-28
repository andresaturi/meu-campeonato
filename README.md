# Descrição

Meu Campeonato, consiste em uma API deselvolvida em PHP 8.2 e Laravel 11, que tem como principal objetivo, definir o vencedor em uma copa de futebol, na qual os times se confrontam em 3 rodadas eliminatorias, sendo as quartas de final, semi-final e final. 

A API, realiza consultas a um script Python, que gera os resultados dos jogos.

Por se tratar de jogos eliminatórios, caso uma partida termine empatada, os criterios de desempate são:

- Tempo Extra:
    Disputa com máximo de 2 gols.

- Pênaltis: 
    Caso no tempo extra continue empatado, serão disputados os pênaltis, na qual, cada time chuta uma vez podendo
    ter dois resultados possíveis, sendo gol ou erro. O time que fizer 5 gols na quinta rodada vence, porém, se 
    ambas equipes tiverem 5 gols na quinta rodada, a disputa continua até alguma equipe ficar á frente da outra.

# Caracteristicas

- Cadastro de Times
- Cadastro de Campeonatos
- Disputa de Campeonato
- Consulta de Times Cadastrados 
- Consulta de Capeonatos Cadastrados 
- Consulta de Resultados de Campeonatos

# Ambiente 

- Laravel Sail

# Documentação 

- http://localhost/docs/api#/ 

# Instalação

- Clone o repositorio <https://github.com.br/andresaturi/meu-campeonato>

- Copie o arquivo .env.example para .env:

- Configure o banco de dados MySQL nas variáveis de ambiente

- Instale as dependencias composer
    composer install

- Inicie o container Docker 
   docker-compose up -d

- Execute as migrations
    ./vendor/bin/sail php artisan migrate

- Execute os seeders
    ./vendor/bin/sail php artisan db:seed