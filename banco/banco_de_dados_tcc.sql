create database tcc;

use tcc;

create table usuario (
    idUsuario int(11) primary key auto_increment,
    isadm boolean  not null,
    isprofessor boolean  not null,
    isparticipante boolean  not null,
    nome varchar(250)  not null,
    usuario varchar(250) not null unique,
    sexo enum('f','m')  not null,
    senha varchar(250)  not null,
    cpf varchar(11)  not null unique,
    email varchar(250)  not null unique,
    endereco varchar(250)  not null,
    numero varchar(6)  not null,
    bairro varchar(250)  not null,
    cidade varchar(250)  not null,
    estado char(2)  not null,
    cep varchar(8)  not null,
    telefone varchar(11)  not null
);


create table evento(
	idEvento int primary key auto_increment,
    validado boolean not null,
    permiteemimssaocertificado boolean not null,
    descricao varchar(250) not null,
    carga_horaria time,
    data_inicio date not null,
    data_fim date not null,
    data_criacao date not null,
    tipo enum('extensao','pesquisa') not null,
    extensao enum('projeto', 'evento', 'curso', ''),
    pesquisa enum('iniciacao cientifica','iniciacao cientifica junior', ''),
    projeto_bolsista boolean,
    projeto_orientador boolean,
    projeto_voluntario boolean,
    projeto_colaborador boolean,
    evento_organizador boolean,
    evento_palestrante boolean,
    evento_ministrante boolean,
    evento_apresentador boolean,
    evento_monitor boolean,
    evento_mediador boolean,
    evento_participante boolean,
    evento_avaliador boolean,
    curso_organizador boolean,
    curso_ministrante boolean,
    curso_participante boolean,
    pesquisa_projeto_ic_orientador boolean,
    pesquisa_projeto_ic_bolsista boolean,
    pesquisa_projeto_ic_voluntario boolean,
    pesquisa_projeto_icj_orientador boolean,
    pesquisa_projeto_icj_bolsista boolean,
    pesquisa_projeto_icj_voluntario boolean,
    sigaextensao boolean,
    id_siga_extansao varchar(250),
    map boolean,
    idmap varchar(250),
    informado_ao_colegiado_do_curso boolean not null,
    numero_ata varchar(250),
    data_ata date,
    outras_ocorrencias varchar(250),
    curso varchar(250), 
    id_usuario_responsavel int not null /*Id do usuario que criou o evento*/    
);

/*ATENÇÃO!!!! Monitores e palestrantes terão que ter seu cadastro feito como um usuario seja de qual natureza for para evitar cadastros desnecessários e uma tabela somente para cadastrar esses usuarios*/
create table participanteevento(
	idParticipanteEvento int primary key auto_increment,
    data_inscricao date,
    entrada time,
    saida time,
    id_usuario int not null,
    id_evento int not null
);

create table planilhaparticipante(

    idPlanilhaParticipante int primary key auto_increment,
    tipo varchar(250) not null,
    curso_nome varchar(250),
    curso_nome_curso varchar(250),
    curso_periodo_realizacao_inicio date,
    curso_periodo_realizacao_fim date,
    curso_carga_horaria time,
    evento_nome_avaliador varchar(250),
    evento_nome varchar (250),
    evento_periodo_realizacao_inicio date,
    evento_periodo_realizacao_fim date,
    evento_numero_posteres_avaliados int,
    projeto_nome_professor_orientador varchar(250),
    projeto_nome_bolsista varchar(250),
    projeto_titulo varchar(250),
    projeto_mes_inicial date,
    projeto_mes_final date,
    projeto_ano date,
    ic_noome_orientador varchar(250),
    ic_nome_bolsiste varchar(250),
    ic_instituicao_fomento varchar(250),
    ic_titulo_projeto varchar(250),
    ic_mes_inicial date,
    ic_mes_final date,
    ic_ano date,
    ic_noome_orientador varchar(250),
    icj_nome_bolsiste varchar(250),
    icj_instituicao_fomento varchar(250),
    icj_titulo_projeto varchar(250),
    icj_mes_inicial date,
    icj_mes_final date,
    icj_ano date,
    id_evento int,
    id_usuario int,

);


/*FOREIGN KEYS*/

alter table evento add constraint fk_id_usuario_responsavel_evento foreign key(id_usuario_responsavel) references usuario(idUsuario);
alter table participanteevento add constraint fk_id_usuario_participanteevento foreign key(id_usuario) references usuario(idUsuario);
alter table participanteevento add constraint fk_id_evento_participanteevento foreign key(id_evento) references evento(idEvento);
alter table planilhaparticipante add constraint fk_id_evento_planilhaparticipante foreign key(id_evento) references evento(idEvento);
alter table planilhaparticipante add constraint fk_id_usuario_planilhaparticipante foreign key(id_usuario) references usuario(idUsuario);