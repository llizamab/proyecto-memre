/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     09-06-2013 19:11:48                          */
/*==============================================================*/

drop table if exists TMM_PROGRAMACION;

drop table if exists TMM_INICIATIVA;

drop table if exists TMM_ETAPA;

drop table if exists TMM_FUENTE;

drop table if exists TMM_UNIDAD_TECNICA;

drop table if exists TMM_TEMPORAL;


/*==============================================================*/
/* Table: TMM_ETAPA                                             */
/*==============================================================*/
create table TMM_ETAPA
(
   ETA_ID               int not null auto_increment,
   ETA_NOMBRE           varchar(255),
   primary key (ETA_ID)
);

/*==============================================================*/
/* Table: TMM_FUENTE                                            */
/*==============================================================*/
create table TMM_FUENTE
(
   FUE_ID               int not null auto_increment,
   FUE_NOMBRE           varchar(255),
   primary key (FUE_ID)
);

/*==============================================================*/
/* Table: TMM_INICIATIVA                                        */
/*==============================================================*/
create table TMM_INICIATIVA
(
   INI_ID               int not null auto_increment,
   FUE_ID               int,
   UTEC_ID              int,
   ETA_ID               int,
   INI_BIP              int,
   INI_ANNO             int,
   INI_PROYECTO         varchar(4000),
   INI_CLASIFICADOR     int,
   INI_MONTO            bigint,
   primary key (INI_ID)
);

/*==============================================================*/
/* Table: TMM_PROGRAMACION                                      */
/*==============================================================*/
create table TMM_PROGRAMACION
(
   REG_ID               int not null auto_increment,
   INI_ID               int,
   PRO_ENERO            bigint,
   PRO_FEBRERO          bigint,
   PRO_MARZO            bigint,
   PRO_ABRIL            bigint,
   PRO_MAYO             bigint,
   PRO_JUNIO            bigint,
   PRO_JULIO            bigint,
   PRO_AGOSTO           bigint,
   PRO_SEPTIEMBRE       bigint,
   PRO_OCTUBRE          bigint,
   PRO_NOVIEMBRE        bigint,
   PRO_DICIEMBRE        bigint,
   primary key (REG_ID)
);

/*==============================================================*/
/* Table: TMM_TEMPORAL                                          */
/*==============================================================*/
create table TMM_TEMPORAL
(
   HIS_ID               int not null auto_increment,
   TEM_MONTO            bigint,
   TEM_NOMBRE           varchar(255),
   TEM_ANNO             int,
   TEM_BIP              int,
   TEM_FUENTE           varchar(10),
   TEM_ETAPA            varchar(255),
   TEM_CUENTA           bigint,
   TEM_ENERO            bigint,
   TEM_FEBRERO          bigint,
   TEM_MARZO            bigint,
   TEM_ABRIL            bigint,
   TEM_MAYO             bigint,
   TEM_JUNIO            bigint,
   TEM_JULIO            bigint,
   TEM_AGOSTO           bigint,
   TEM_SEPTIEMBRE       bigint,
   TEM_OCTUBRE          bigint,
   TEM_NOVIEMBRE        bigint,
   TEM_DICIEMBRE        bigint,
   TEM_UNI_TEC          varchar(255),
   TEM_NUMERO_COLUMNA   bigint,
   TEM_ERRORES          varchar(5000),
   primary key (HIS_ID)
);

/*==============================================================*/
/* Table: TMM_UNIDAD_TECNICA                                    */
/*==============================================================*/
create table TMM_UNIDAD_TECNICA
(
   UTEC_ID              int not null auto_increment,
   UTEC_NOMBRE          varchar(255),
   primary key (UTEC_ID)
);

alter table TMM_INICIATIVA add constraint FK_REFERENCE_2 foreign key (FUE_ID)
      references TMM_FUENTE (FUE_ID) on delete restrict on update restrict;

alter table TMM_INICIATIVA add constraint FK_REFERENCE_3 foreign key (UTEC_ID)
      references TMM_UNIDAD_TECNICA (UTEC_ID) on delete restrict on update restrict;

alter table TMM_INICIATIVA add constraint FK_REFERENCE_4 foreign key (ETA_ID)
      references TMM_ETAPA (ETA_ID) on delete restrict on update restrict;

alter table TMM_PROGRAMACION add constraint FK_REFERENCE_1 foreign key (INI_ID)
      references TMM_INICIATIVA (INI_ID) on delete restrict on update restrict;

