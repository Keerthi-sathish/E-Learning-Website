
# database schema for e-learning website

## create database
create database user_auth;
use user_auth;

## users table
create table users (
    id int(11) auto_increment primary key,
    name varchar(100) not null,
    email varchar(100) not null unique,
    password varchar(255) not null,
    created_at timestamp default current_timestamp
);

## courses table
create table courses (
    id int(11) auto_increment primary key,
    name varchar(255) not null,
    description text not null,
    video_url varchar(500) not null,
    image_url varchar(255) not null
);

## enrollments table
create table enrollments (
    id int(11) auto_increment primary key,
    user_id int(11) not null,
    course_id int(11) not null,
    enrolled_at timestamp default current_timestamp,
    foreign key (user_id) references users(id) on delete cascade,
    foreign key (course_id) references courses(id) on delete cascade
);

## feedback table
create table feedback (
    id int(11) auto_increment primary key,
    user_id int(11) not null,
    feedback text not null,
    rating int(11) not null,
    created_at timestamp default current_timestamp,
    foreign key (user_id) references users(id) on delete cascade
);

## user sessions table
create table user_sessions (
    id int(11) auto_increment primary key,
    user_id int(11) not null,
    login_time time not null,
    login_date date not null,
    foreign key (user_id) references users(id) on delete cascade
);
