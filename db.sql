create table sm_fees_classes(
    id int primary key auto_increment,
    title text,
    amount decimal,
    sm_class_id bigint,
    foreign key(sm_class_id) references sm_classes(id),
    created_at timestamp,
    updated_at timestamp
);