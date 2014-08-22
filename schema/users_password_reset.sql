/*DROP TABLE users_password_reset;*/
CREATE TABLE users_password_reset (
  password_reset_code varchar(80) NOT NULL,
  user_id int NOT NULL,
  password_reset_date date NOT NULL,
  PRIMARY KEY  (password_reset_code),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
)
