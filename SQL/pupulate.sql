
-- populate category
INSERT INTO category (name) VALUES ('limpeza');
INSERT INTO category (name) VALUES ('alimento');
INSERT INTO category (name) VALUES ('higiente pessoal');
INSERT INTO category (name) VALUES ('congelados');*/

-- populate product
INSERT INTO product (category_id, name, quantity, price) VALUES (1, 'sabao líquido', 5, 15.90);
INSERT INTO product (category_id, name, quantity, price) VALUES (1, 'sabao em pó', 2, 13.50);
INSERT INTO product (category_id, name, quantity, price) VALUES (2, 'arroz', 9, 39.90);
INSERT INTO product (category_id, name, quantity, price) VALUES (2, 'feijao', 15, 9,58);
INSERT INTO product (category_id, name, quantity, price) VALUES (3, 'sabonete', 19, 2.70);
INSERT INTO product (category_id, name, quantity, price) VALUES (3, 'creme dental', 20, 4.45);
INSERT INTO product (category_id, name, quantity, price) VALUES (4, 'peito de frango', 25, 6.99);
INSERT INTO product (category_id, name, quantity, price) VALUES (4, 'picanha', 14, 79.90);


