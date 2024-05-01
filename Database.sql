create database toko_online;
use toko_online;

CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) DEFAULT NULL,
  balance int(11) DEFAULT NULL,
  gender enum('male','female') NOT NULL,
  phone_number varchar(255) NOT NULL,
  address text NOT NULL,
  jobs varchar(255) NOT NULL,
  date_of_birth date NOT NULL,
  username varchar(50) NOT NULL,
  image varchar(255) DEFAULT NULL,
  status enum('admin','user') NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  modified_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE sessions (
  id varchar(255) NOT NULL,
  user_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_sessions_user (user_id),
  CONSTRAINT fk_sessions_user FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  description text NOT NULL,
  category varchar(255) NOT NULL,
  color varchar(255) NOT NULL,
  capacity enum('8GB','16GB','32GB','64GB','128GB','256GB','512GB','1TB') NOT NULL,
  price int(255) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  modified_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  stock int(11) NOT NULL,
  image varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4;

CREATE TABLE shopping_session (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  total int(11) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  modified_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  KEY fk_shopping_session (user_id),
  CONSTRAINT fk_shopping_session FOREIGN KEY (user_id) REFERENCES users (id)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4;

CREATE TABLE cart_item (
  id int(11) NOT NULL AUTO_INCREMENT,
  session_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  quantity int(11) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  modified_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  KEY fk_cart_item (session_id),
  KEY fk_cart_item_product (product_id),
  CONSTRAINT fk_cart_item FOREIGN KEY (session_id) REFERENCES shopping_session (id),
  CONSTRAINT fk_cart_item_product FOREIGN KEY (product_id) REFERENCES products (id)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NULL,
    total DECIMAL(10,2) NOT NULL,
    payment_id VARCHAR(255) NOT NULL,
    order_id VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(255) NOT NULL,
    product_id VARCHAR(255) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at_payment TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at_order TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- CREATE TABLE order_details (
--   id int(11) NOT NULL AUTO_INCREMENT,
--   total decimal(10,0) NOT NULL,
--   payment_id int(11) DEFAULT NULL,
--   user_id int(11) NOT NULL,
--   created_at timestamp NOT NULL DEFAULT current_timestamp(),
--   modified_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
--   PRIMARY KEY (id),
--   KEY fk_order_details_payment (payment_id),
--   KEY fk_order_details (user_id),
--   CONSTRAINT fk_order_details FOREIGN KEY (user_id) REFERENCES users (id),
--   CONSTRAINT fk_order_details_payment FOREIGN KEY (payment_id) REFERENCES payment_details (id)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE order_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  total decimal(10,0) NOT NULL,
  payment_id int(11) DEFAULT NULL,
  user_id int(11) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  modified_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  KEY fk_order_details_payment (payment_id),
  KEY fk_order_details (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE order_items (
  id int(11) NOT NULL AUTO_INCREMENT,
  order_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  modified_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  KEY fk_order_items (order_id),
  KEY fk_order_items_product_id (product_id),
  CONSTRAINT fk_order_items FOREIGN KEY (order_id) REFERENCES order_details (id),
  CONSTRAINT fk_order_items_product_id FOREIGN KEY (product_id) REFERENCES products (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- CREATE TABLE payment_details (
--   id int(11) NOT NULL AUTO_INCREMENT,
--   order_id int(11) NOT NULL,
--   amount int(11) NOT NULL,
--   status enum('success','failed') DEFAULT NULL,
--   created_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
--   PRIMARY KEY (id),
--   KEY fk_payment_details (order_id),
--   CONSTRAINT fk_payment_details FOREIGN KEY (order_id) REFERENCES order_details (id)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE payment_details (
  id int(11) NOT NULL AUTO_INCREMENT,
  order_id int(11) NOT NULL,
  amount int(11) NOT NULL,
  status enum('success','failed') DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id),
  KEY fk_payment_details (order_id),
  CONSTRAINT fk_payment_details FOREIGN KEY (order_id) REFERENCES order_details (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


select * from users;





