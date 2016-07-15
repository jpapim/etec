drop table if exists tipo_tcc;

/*==============================================================*/
/* Table: tipo_tcc                                              */
/*==============================================================*/
create table tipo_tcc
(
   id_tipo_tcc          smallint not null auto_increment,
   nm_tipo_tcc          varchar(30),
   primary key (id_tipo_tcc)
);

drop table if exists area_conhecimento;

/*==============================================================*/
/* Table: area_conhecimento                                     */
/*==============================================================*/
create table area_conhecimento
(
   id_area_conhecimento smallint not null auto_increment,
   nm_area_conhecimento varchar(50),
   primary key (id_area_conhecimento)
);

drop table if exists palavra_chave;

/*==============================================================*/
/* Table: palavra_chave                                         */
/*==============================================================*/
create table palavra_chave
(
   id_palavra_chave     bigint not null auto_increment,
   nm_palavra_chave     varchar(25),
   primary key (id_palavra_chave)
);

drop table if exists banca_examinadora;

/*==============================================================*/
/* Table: banca_examinadora                                     */
/*==============================================================*/
create table banca_examinadora
(
   id_banca_examinadora int not null auto_increment,
   dt_banca             timestamp default NULL,
   primary key (id_banca_examinadora)
);

drop table if exists curso;

/*==============================================================*/
/* Table: curso                                                 */
/*==============================================================*/
create table curso
(
   id_curso             int not null auto_increment,
   nm_curso             varchar(50),
   primary key (id_curso)
);

drop table if exists titulacao;

/*==============================================================*/
/* Table: titulacao                                             */
/*==============================================================*/
create table titulacao
(
   id_titulacao         smallint not null auto_increment,
   nm_titulacao         varchar(35),
   primary key (id_titulacao)
);

drop table if exists professor;

/*==============================================================*/
/* Table: professor                                             */
/*==============================================================*/
create table professor
(
   id_professor         smallint not null auto_increment,
   id_titulacao         smallint,
   id_usuario_cadastro  int(11),
   nm_professor         varchar(50),
   dt_cadastro          timestamp default CURRENT_TIMESTAMP,
   cs_orientador        char(1),
   cs_ativo             char(1),
   primary key (id_professor)
);

alter table professor add constraint FK_Reference_90 foreign key (id_titulacao)
      references titulacao (id_titulacao) on delete restrict on update restrict;

alter table professor add constraint FK_Reference_91 foreign key (id_usuario_cadastro)
      references usuario (id_usuario) on delete restrict on update restrict;


drop table if exists membros_banca;

/*==============================================================*/
/* Table: membros_banca                                         */
/*==============================================================*/
create table membros_banca
(
   id_membro_banca      int not null auto_increment,
   id_banca_examinadora int,
   id_professor         smallint,
   primary key (id_membro_banca)
);

alter table membros_banca add constraint FK_Reference_97 foreign key (id_banca_examinadora)
      references banca_examinadora (id_banca_examinadora) on delete restrict on update restrict;

alter table membros_banca add constraint FK_Reference_98 foreign key (id_professor)
      references professor (id_professor) on delete restrict on update restrict;

drop table if exists tcc;

/*==============================================================*/
/* Table: tcc                                                   */
/*==============================================================*/
create table tcc
(
   id_tcc               bigint not null auto_increment,
   id_usuario_cadastro  int(11),
   id_usuario_alteracao int(11),
   id_banca_examinadora int,
   id_area_conhecimento smallint,
   id_tipo_tcc          smallint,
   id_professor_orientador smallint,
   tx_titulo_tcc        varchar(150),
   tx_resumo            text,
   dt_cadastro          timestamp default CURRENT_TIMESTAMP,
   dt_alteracao         timestamp default CURRENT_TIMESTAMP,
   nr_nota_final        decimal(4,2),
   primary key (id_tcc)
);

alter table tcc add constraint FK_Reference_103 foreign key (id_professor_orientador)
      references professor (id_professor) on delete restrict on update restrict;

alter table tcc add constraint FK_Reference_93 foreign key (id_usuario_cadastro)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table tcc add constraint FK_Reference_94 foreign key (id_usuario_alteracao)
      references usuario (id_usuario) on delete restrict on update restrict;

alter table tcc add constraint FK_Reference_95 foreign key (id_banca_examinadora)
      references banca_examinadora (id_banca_examinadora) on delete restrict on update restrict;

alter table tcc add constraint FK_Reference_96 foreign key (id_area_conhecimento)
      references area_conhecimento (id_area_conhecimento) on delete restrict on update restrict;

alter table tcc add constraint FK_Reference_99 foreign key (id_tipo_tcc)
      references tipo_tcc (id_tipo_tcc) on delete restrict on update restrict;

drop table if exists concluinte;

/*==============================================================*/
/* Table: concluinte                                            */
/*==============================================================*/
create table concluinte
(
   id_concluinte        int not null auto_increment,
   id_curso             int,
   id_tcc               bigint,
   nm_concluinte        varchar(50),
   nr_matricula         varchar(20),
   primary key (id_concluinte)
);

alter table concluinte add constraint FK_Reference_102 foreign key (id_tcc)
      references tcc (id_tcc) on delete restrict on update restrict;

alter table concluinte add constraint FK_Reference_92 foreign key (id_curso)
      references curso (id_curso) on delete restrict on update restrict;

drop table if exists palavra_chave_tcc;

/*==============================================================*/
/* Table: palavra_chave_tcc                                     */
/*==============================================================*/
create table palavra_chave_tcc
(
   id_palavra_chave_tcc bigint not null auto_increment,
   id_tcc               bigint,
   id_palavra_chave     bigint,
   primary key (id_palavra_chave_tcc)
);

alter table palavra_chave_tcc add constraint FK_Reference_100 foreign key (id_tcc)
      references tcc (id_tcc) on delete restrict on update restrict;

alter table palavra_chave_tcc add constraint FK_Reference_101 foreign key (id_palavra_chave)
      references palavra_chave (id_palavra_chave) on delete restrict on update restrict;

	  
	  
	  


