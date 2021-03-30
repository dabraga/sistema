CREATE DATABASE IF NOT EXISTS db_blog;

USE db_blog;

CREATE TABLE tab_clientes(
	id integer auto_increment primary key,
	nome varchar(100),
	cpf varchar(20),
	email varchar(50),
	telefone varchar(20),
	celular varchar(20),
	data_nascimento date,
	status varchar(10),
    foto varchar(200),
	data_cadastro timestamp default CURRENT_TIMESTAMP,
	data_alteracao timestamp default CURRENT_TIMESTAMP
);


--
-- Estrutura para tabela `tab_endereco`
--

CREATE TABLE `tab_endereco` (
  `id` int(11) NOT NULL,
  `tab_cliente_id` int(11) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `bairro` varchar(40) NOT NULL,
  `cep` char(10) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `estado` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tab_endereco`
--
ALTER TABLE `tab_endereco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tab_cliente_id` (`tab_cliente_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tab_endereco`
--
ALTER TABLE `tab_endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tab_endereco`
--
ALTER TABLE `tab_endereco`
  ADD CONSTRAINT `tab_endereco_ibfk_1` FOREIGN KEY (`tab_cliente_id`) REFERENCES `tab_clientes` (`id`);


CREATE TABLE `tab_login` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `senha` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tab_login`
--
ALTER TABLE `tab_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tab_login`
--
ALTER TABLE `tab_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


--
-- Despejando dados para a tabela `tab_login`
--

INSERT INTO `tab_login` (`usuario`, `senha`) VALUES
('admin', 'admin');