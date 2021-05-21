/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  19/03/2021 16:35:50                      */
/*==============================================================*/


drop table if exists T_INFO_MOVIES;

drop table if exists T_MOVIES;

drop table if exists T_PRETS;

drop table if exists T_ROLES;

drop table if exists T_USERS;

/*==============================================================*/
/* Table : T_INFO_MOVIES                                        */
/*==============================================================*/
create table T_INFO_MOVIES
(
   ID_INFO              int not null auto_increment,
   ID_MOVIE             int not null,
   ID_USER              int not null,
   RATE                 decimal(2,1),
   COMMENT              varchar(255),
   SHARE                bool default 0,
   SEE                  bool,
   TO_SEE               bool,
   primary key (ID_INFO)
);

/*==============================================================*/
/* Table : T_MOVIES                                             */
/*==============================================================*/
create table T_MOVIES
(
   ID_MOVIE             int not null auto_increment,
   NAME                 varchar(120) not null,
   POSTER               varchar(255) not null,
   ORIGIN               varchar(64),
   VO                   varchar(64),
   ACTORS               varchar(255),
   DIRECTOR             varchar(255),
   GENRE                varchar(255),
   RELEASE_DATE         date,
   PRODUCTION           varchar(120),
   RUNTIME              int not null,
   TRAILER              varchar(255),
   NOMINATION           text,
   SYNOPSIS             text not null,
   DVD                  bool,
   primary key (ID_MOVIE)
);

/*==============================================================*/
/* Table : T_PRETS                                              */
/*==============================================================*/
create table T_PRETS
(
   ID_PRET              int not null auto_increment,
   ID_USER              int not null,
   ID_MOVIE             int not null,
   ID_USER_PRET         int,
   DATE_PRET            date,
   DATE_RETOUR          date,
   primary key (ID_PRET)
);

/*==============================================================*/
/* Table : T_ROLES                                              */
/*==============================================================*/
create table T_ROLES
(
   ID_ROLES             int not null auto_increment,
   ID_USER              int not null,
   ISADMIN              bool not null,
   NAME                 varchar(120),
   primary key (ID_ROLES)
);

/*==============================================================*/
/* Table : T_USERS                                              */
/*==============================================================*/
create table T_USERS
(
   ID_USER              int not null auto_increment,
   PSEUDO               varchar(40) not null,
   MAIL                 varchar(120) not null,
   PASSWORD             varchar(120) not null,
   ID_ROLE              char(10) not null,
   primary key (ID_USER)
);

alter table T_INFO_MOVIES add constraint FK_MOVIES_MOVIES_INFO foreign key (ID_MOVIE)
      references T_MOVIES (ID_MOVIE) on delete restrict on update restrict;

alter table T_INFO_MOVIES add constraint FK_USERS_MOVIES foreign key (ID_USER)
      references T_USERS (ID_USER) on delete restrict on update restrict;

alter table T_PRETS add constraint FK_PRET_MOVIES foreign key (ID_MOVIE)
      references T_MOVIES (ID_MOVIE) on delete restrict on update restrict;

alter table T_PRETS add constraint FK_USER_PRET foreign key (ID_USER)
      references T_USERS (ID_USER) on delete restrict on update restrict;

alter table T_ROLES add constraint FK_USERS_ROLES foreign key (ID_USER)
      references T_USERS (ID_USER) on delete restrict on update restrict;

