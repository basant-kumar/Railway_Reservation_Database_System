--insert data into trains table , stations and schedule
create table status(train_no int(10),ts_ac1 int(10),bs_ac1 int(10),ts_ac2 int(10),bs_ac2 int(10),ts_ac3 int(10),bs_ac3 int(10),
					ts_sl int(10),bs_sl int(10),a_date date);

--insertation for trains table		
insert into trains values(12345,'Express','Rajasthan Sampark kranti express');
insert into trains values(12346,'Super Fast Ex','Purushottam SF Express');
insert into trains values(12347,'Rajdhani','Rajdhani Express');
insert into trains values(12348,'Duronto','Duronto Express');
insert into trains values(12349,'SF Express','Pooja SF Express');

--insertation for stations table
insert into stations(stn_code,stn_name) values('JU','Jodhpur Junction'),('MTD','Merta Road Junction'),('DNA','Degana Junction')
		,('MKN','Makrana Junction'),('JP','Jaipur Junction'),('AWR','Alwar Junction'),('DEC','Delhi');
insert into stations values('PURI','Puri'),('BBS','Bhubaneswar'),('KUR','Khurdha'),('KGP','Kharagpur'),('GAYA','Gaya'),
							('ALD','Allahabad'),('CNB','Kanpur'),('NDLS','New Delhi');
							
		


--insertation for schedule table
insert into schedule values(12345,'JU',null,'19:00:00',0,0,0),(12345,'MTD','20:14:00','20:35:00',102,100,0),
				(12345,'Dna','21:08:00','21:11:00',146,200,0),(12345,'MKN','21:46:00','21:48:00',190,300,0),
				(12345,'JP','00:15:00','00:25:00',310,400,1),(12345,'AWR','02:20:00','02:30:00',460,500,1),
				(12345,'DEC','05:06:00',null,604,600,1);
				
insert into schedule values(12346,'PURI',null,'21:45:00',0,0,0),(12346,'KUR','22:35:00','22:40:00',50,100,0),
					(12346,'BBS','23:10:00','23:15:00',62,200,0),(12346,'KGP','04:10:00','04:40:00',322,200,1),
					(12346,'GAYA','14:00:00','14:05:00',809,400,1),(12346,'ALD','19:40:00','19:45:00',1160,600,1),
					(12346,'CNB','22:05:00','22:10:00',1366,800,1),(12346,'NDLS','04:30:00'	,null,1800,100,2);

insert into schedule values(12347,'BBS',null,'11:40:00',0,0,0),(12347,'KGP','15:55:00','16:10:00',322,400,0),
							(12347,'CNB','05:20:00','05:30:00',1300,1400,1),(12347,'NDLS','10:40:00',null,1750,2000,1);
						
insert into schedule values(12348,'BBS',null,'08:10:00',0,0,0),(12348,'CNB','00:50:00','00:55:00',1300,1000,1),
							(12348,'NDLS','06:25:00',null,1750,2000,1);
							
insert into schedule values(12349,'DEC',null,'03:55:00',0,0,0),(12349,'AWR','07:10:00','07:20:00',200,150,0),
							(12349,'JP','10:00:00',null,300,200,0);
			
			
--insertation for status table
insert into status values(12345,'sleeper',160,0,2),(12345,'3rd-ac',80,0,1),(12345,'2rd-ac',80,0,1),(12345,'1rd-ac',80,0,1);

--insertation for trains_availability table
insert into trains_availability values(12345,0);
insert into trains_availability values(12346,0),(12346,1),(12346,2),(12346,3),(12346,4),(12346,5),(12346,6); 
insert into trains_availability values(12347,0),(12347,3),(12347,6);
insert into trains_availability values(12348,3);
insert into trains_availability values(12349,0),(12349,1),(12349,2),(12349,3),(12349,4),(12349,5),(12349,6); 




create table cancel_tickets(pnr_no int(10), train_no  int(10),coach varchar(10),seat_no int(10),c_doj date);
ALTER TABLE `cancel_tickets`  ADD KEY `fk7` (`pnr_no`);
ALTER TABLE `cancel_tickets`  ADD KEY `fk8` (`train_no`);