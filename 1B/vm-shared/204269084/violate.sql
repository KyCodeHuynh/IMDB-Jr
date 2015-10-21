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

# Foreign Key 1: MovieGenre(mid) references Movie(id)
INSERT INTO MovieGenre VALUES(5555, "Horror");
# Won't work because MovieGenre has a foreign key to Movie ID
# Output: "ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails ('CS143'.'MovieGenre', CONSTRAINT 'MovieGenre_ibfk_1' FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))

# Foreign Key 2: MovieDirector references Movie(id)
UPDATE Director SET id=110 WHERE first='Jim';
# Can't update Director because it will affect MovieDirector's link to the right Movie ID
# Output: "ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails ('CS143'.'MovieDirector', CONSTRAINT 'MovieDirector_ibfk_2' FOREIGN KEY ('did') REFERENCES 'Director' ('id'))"

# Foreign Key 3;
MovieActor
DELETE FROM Movie WHERE id=4147
# Output: "ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails ('CS143'.'MovieActor', CONSTRAINT 'MovieActor_ibfk_1' FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))"

