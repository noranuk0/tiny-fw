create schema area;

CREATE TABLE area.m_regions (
	id serial,
	region_id integer unique not null,
	name text not null
);

CREATE TABLE area.m_prefectures (
	id serial,
	region_id integer not null,
	prefecture_id integer unique not null,
	name text not null
);

