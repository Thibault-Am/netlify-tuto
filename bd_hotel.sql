\c postgres
drop database if exists bd_hotel;

create database bd_hotel;

\c bd_hotel

create table client (
    id serial,

    nom varchar(50),
    prenom varchar(50),
    ville varchar(50),
    primary key (id)  
);

create table chambre(
    id serial,
    
    date date,
    client_id int,
    numero int,
    taille varchar(30),
    primary key (id),
    foreign key (client_id) references client(id)
);    

drop user if exists uti_hotel;
create user uti_hotel login password 'xy72aR'; 

grant all on client to uti_hotel;
grant all on client_id_seq to uti_hotel; -- à cause de serial
grant all on chambre to uti_hotel;
grant all on chambre_id_seq to uti_hotel; 
--------------insertion des données fixes des chambres--------------------------

--------------RDC---------------------------------------------------------------
insert into chambre(numero, taille) values(1, 'normale');
insert into chambre(numero, taille) values(2, 'normale');
insert into chambre(numero, taille) values(3, 'normale');
insert into chambre(numero, taille) values(4, 'normale');
insert into chambre(numero, taille) values(5, 'grande_horizontale');
insert into chambre(numero, taille) values(6, 'normale');
insert into chambre(numero, taille) values(7, 'normale');
insert into chambre(numero, taille) values(8, 'normale');
insert into chambre(numero, taille) values(9, 'normale');
insert into chambre(numero, taille) values(10, 'grande_verticale');
insert into chambre(numero, taille) values(11, 'normale');
insert into chambre(numero, taille) values(12, 'normale');
insert into chambre(numero, taille) values(13, 'grande_horizontale');

--------------étage 1-----------------------------------------------------------
insert into chambre(numero, taille) values(101, 'normale');
insert into chambre(numero, taille) values(102, 'normale');
insert into chambre(numero, taille) values(103, 'grande_horizontale');
insert into chambre(numero, taille) values(104, 'normale');
insert into chambre(numero, taille) values(105, 'normale');
insert into chambre(numero, taille) values(106, 'normale');
insert into chambre(numero, taille) values(107, 'normale');
insert into chambre(numero, taille) values(108, 'normale');
insert into chambre(numero, taille) values(109, 'normale');
insert into chambre(numero, taille) values(110, 'grande_verticale');
insert into chambre(numero, taille) values(111, 'normale');
insert into chambre(numero, taille) values(112, 'normale');
insert into chambre(numero, taille) values(113, 'suite');

--------------étage 2-----------------------------------------------------------
insert into chambre(numero, taille) values(201, 'suite');
insert into chambre(numero, taille) values(202, 'grande_horizontale');
insert into chambre(numero, taille) values(203, 'grande_horizontale');
insert into chambre(numero, taille) values(204, 'normale');
insert into chambre(numero, taille) values(205, 'normale');
insert into chambre(numero, taille) values(206, 'grande_verticale');
insert into chambre(numero, taille) values(207, 'normale');
insert into chambre(numero, taille) values(208, 'normale');
insert into chambre(numero, taille) values(209, 'suite');

