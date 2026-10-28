CREATE DATABASE IF NOT EXISTS looply
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE looply;

create table categories
(
    id          int unsigned auto_increment
        primary key,
    name        varchar(100)                       not null,
    description text                               null,
    created_at  datetime default CURRENT_TIMESTAMP not null,
    updated_at  datetime default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint uq_categories_name
        unique (name)
)ENGINE=InnoDB;

create table users
(
    id            int unsigned auto_increment
        primary key,
    first_name    varchar(100)                                     not null,
    last_name     varchar(100)                                     not null,
    email         varchar(255)                                     not null,
    password_hash varchar(255)                                     not null,
    role          enum ('user', 'admin') default 'user'            not null,
    avatar_url    varchar(500)                                     null,
    location      varchar(255)                                     null,
    bio           text                                             null,
    created_at    datetime               default CURRENT_TIMESTAMP not null,
    updated_at    datetime               default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint uq_users_email
        unique (email)
)ENGINE=InnoDB;

create table projects
(
    id          int unsigned auto_increment
        primary key,
    user_id     int unsigned                                         not null,
    category_id int unsigned                                         not null,
    title       varchar(255)                                         not null,
    description text                                                 null,
    image_url   varchar(500)                                         not null,
    privacy     enum ('public', 'private') default 'private'         not null,
    created_at  datetime                   default CURRENT_TIMESTAMP not null,
    updated_at  datetime                   default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint fk_projects_category
        foreign key (category_id) references categories (id)
            on delete restrict
            on update cascade,
    constraint fk_projects_user
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
)ENGINE=InnoDB;

create table favorites
(
    user_id    int unsigned                       not null,
    project_id int unsigned                       not null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    primary key (user_id, project_id),
    constraint fk_favorites_project
        foreign key (project_id) references projects (id)
            on update cascade on delete cascade,
    constraint fk_favorites_user
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
)ENGINE=InnoDB;

create table reviews
(
    id               int unsigned auto_increment
        primary key,
    project_id       int unsigned                       not null,
    user_id          int unsigned                       not null,
    rating           tinyint unsigned                   not null,
    pattern_source   text                               null,
    pattern_url      varchar(500)                       null,
    yarn_used        varchar(255)                       null,
    hook_needle_size varchar(100)                       null,
    notes            text                               null,
    created_at       datetime default CURRENT_TIMESTAMP not null,
    updated_at       datetime default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint fk_reviews_project
        foreign key (project_id) references projects (id)
            on update cascade on delete cascade,
    constraint fk_reviews_user
        foreign key (user_id) references users (id)
            on update cascade on delete cascade,
    constraint chk_reviews_rating
        check (`rating` between 1 and 5)
)ENGINE=InnoDB;


