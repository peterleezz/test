create table yoga_pay_back(
	`id` bigint(20) NOT NULL AUTO_INCREMENT,
	contract_id bigint(20) NOT NULL,
	`brand_id` bigint(20) NOT NULL DEFAULT '0',
	`club_id` bigint(20) NOT NULL DEFAULT '0',
	`apply_id` bigint(20) NOT NULL DEFAULT '0',
	review_id bigint(20) NOT NULL,
	ret tinyint not null default 0 comment '0--undeal 1--agree 2--disagree',
	pay_back_price double not null default 0,
	create_time timestamp not null,
	update_time timestamp not null default '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	KEY idx_club_id(club_id),
	KEY idx_brand_id(brand_id)
);