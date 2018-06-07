CREATE DATABASE IF NOT EXISTS DailyTrends;
USE DailyTrends;

CREATE TABLE feeds(

	id 	int(255) auto_increment not null,
	title varchar(255) not null,
	body varchar(255),
	image varchar(255),
	source varchar(255),
	publisher varchar(255),
	created_at datetime,
	updated_at datetime,
	
	CONSTRAINT pk_feeds PRIMARY KEY(id)  
	 

)ENGINE = InnoDb;
