  <h1>Sistema de Autenticação</h1>
  <p>
      Este é um projeto de sistema de autenticação que permite a criação e o login de usuários. Foi desenvolvido como
      seminário para a Uniasselvi.
  </p>

  <h2>Funcionalidades</h2>
  <ul>
      <li><strong>Registro de Usuário:</strong> Permite que novos usuários se cadastrem no sistema.</li>
      <li><strong>Login de Usuário:</strong> Permite que usuários registrados façam login no sistema.</li>
      <li><strong>Autenticação:</strong> Garante que apenas usuários autenticados possam acessar certas partes do
          sistema.</li>
      <li><strong>Validação de Senha:</strong> Senhas são validadas e armazenadas de forma segura.</li>
  </ul>

  <h2>Tecnologias Utilizadas</h2>
  <ul>
      <li><strong>Frontend:</strong> HTML, CSS, JavaScript</li>
      <li><strong>Backend:</strong> PHP</li>
      <li><strong>Banco de Dados:</strong> MySQL</li>
  </ul>

  <h2>Instalação</h2>
  <ol>
      <li>
          <p><strong>Clone o repositório:</strong></p>
          <pre><code>git clone https://github.com/C0nanT/stm_auth.git</code></pre>
      </li>
      <li>
          <p><strong>Navegue até o diretório do projeto:</strong></p>
          <pre><code>cd stm_auth</code></pre>
      </li>
      <li>
          <p><strong>Configure o banco de dados:</strong></p>
          <p>Após acessar a pasta do projeto no terminal, execute a migração</p>
          <pre><code>php database/migrate.php</code></pre>
      </li>
      <li>
          <p><strong>Configure as variáveis de ambiente:</strong></p>
          <p>Edite o arquivo <code>config.php</code> com as informações do seu banco de dados.</p>
      </li>
      <li>
          <p><strong>Inicie o servidor:</strong></p>
          <p>Coloque os arquivos do projeto no diretório raiz do seu servidor web (ex: <code>htdocs</code> para XAMPP) e
              inicie o servidor.</p>
      </li>
  </ol>

<h2>Instalação com Docker</h2>
<p>Este projeto pode ser facilmente instalado e executado com Docker e Docker Compose. Siga as instruções abaixo para instalar e iniciar o projeto:</p>
<ol>
    <li>
        <p><strong>Instale o Docker e o Docker Compose:</strong></p>
        <p>Se você ainda não tem o Docker e o Docker Compose instalados, siga as instruções na seção "Instalação do Docker e Docker Compose no Windows" abaixo.</p>
    </li>
    <li>
        <p><strong>Clone o repositório:</strong></p>
        <pre><code>git clone https://github.com/C0nanT/stm_auth.git</code></pre>
    </li>
    <li>
        <p><strong>Navegue até o diretório do projeto:</strong></p>
        <pre><code>cd stm_auth</code></pre>
    </li>
    <li>
        <p><strong>Construa e inicie os containers Docker:</strong></p>
        <pre><code>docker-compose up -d</code></pre>
    </li>
</ol>

<h2>Acessando o Projeto</h2>
<p>Após a instalação e inicialização dos containers Docker, o projeto estará disponível no seguinte endereço:</p>
<pre><code>http://localhost:8000</code></pre>
<p>Abra este endereço em um navegador web para acessar o sistema de autenticação.</p>
  <h2>Contribuição</h2>
      <ul>
        <li><a href="https://github.com/c0nant">Conan Torres</a></li>
        <li><a href="https://github.com/thiagoedson">Thiago Edson</a></li>
        <li><a href="https://github.com/gabrielabarreto">Gabriela Barreto de Sousa</a></li>
        <li><a href="https://github.com/FabioSimones">Fábio Simones</a></li>
        <li><a href="https://github.com/ViniGois">Vinicius Goes</a></li>
    </ul>
