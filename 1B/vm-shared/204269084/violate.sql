# Primary Key 1: Movie ID is a primary key
INSERT INTO Movie VALUES(NULL, 'title', 2000, 0, 'Warner');
# Won't work because Movie can't have a null value for Movie ID
# Output: "ERROR 1048 (23000): Column 'id' cannot be null"

# Primary Key 2: Actor ID is a primary key
# ASSUMPTION: There's already an Actor with Actor ID = 1
INSERT INTO Actor VALUES(1, 'Pitt', 'Brad', 'male', 19901010, NULL);
# Won't work because Actor can't have two actors with the id = 1
# Output: "ERROR 1062 (23000): Duplicate entry '1' for key 'PRIMARY'"

# Primary Key 3: Director ID is a primary key
INSERT INTO Director VALUES(NULL, 'Jolie', 'Angelina', 19901010, NULL);
# Won't work because Director can't have null value for Director ID
# Output: "ERROR 1048 (23000): Column 'id' cannot be null"

