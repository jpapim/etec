alter table banca_examinadora add column id_professor smallint after id_banca_examinadora;

alter table banca_examinadora add constraint FK_Reference_104 foreign key (id_professor)
      references professor (id_professor) on delete restrict on update restrict;
