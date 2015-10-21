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
UPDATE MovieDirector SET mid=500 WHERE did=112;
# Can't update MovieDirector because it references a Movie ID that doesn't exist in Movie
# Output: "ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails ('CS143'.'MovieDirector', CONSTRAINT 'MovieDirector_ibfk_2' FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))"

# Foreign Key 3: MovieDirector references Director(id)
UPDATE Director SET id=110 WHERE first='Jim';
# Can't update Director because it will affect MovieDirector's link to the right Movie ID
# Output: "ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails ('CS143'.'MovieDirector', CONSTRAINT 'MovieDirector_ibfk_2' FOREIGN KEY ('did') REFERENCES 'Director' ('id'))"

# Foreign Key 4: MovieActor references Movie(id)
DELETE FROM Movie WHERE id=4147;
# Can't delete an id from Movie because it will affect MovieActor's reference
# Output: "ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails ('CS143'.'MovieActor', CONSTRAINT 'MovieActor_ibfk_1' FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))"

# Foreign Key 5: MovieActor references Actor(id)
DELETE FROM Actor WHERE id=59;
# Can't delete an id from Actor because it will affect MovieActor's reference
# Output: "ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails ('CS143'.'MovieActor', CONSTRAINT 'MovieActor_ibfk_1' FOREIGN KEY ('aid') REFERENCES 'Movie' ('id'))"

# Foreign Key 6: Review references Movie(id)
INSERT INTO Review VALUES('Crystal', NULL, 20000, NULL, NULL);
# Can't add a Movie ID into Review that's not in Movie 
# Output: "ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails ('CS143'.'Review', CONSTRAINT 'Review_ibfk_1' FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))"

# Check Constraint 1: Checks that the release year is after 1880 (the first films) and before 2016
INSERT INTO Movie VALUES(1, 'Up', 1000, 5, 'Pixar');
# If Checks worked, then it would violate the rule of being after 1880
# The release year of 1000 is not possible. 
# It would prevent the user from making this row.

# Check Constraint 2: Checks that the sex of an Actor is either 'female' or 'male'
INSERT INTO Actor VALUES(2, 'Cooper', 'Bradley', 'cat', 19900404, NULL);
# If Checks worked, it would violate the rule of not being 'female' or 'male'
# It would prevent the user from making this row.

# Check Constraint 3: Checks that the date of birth of an Actor is greater than 0 and before today's date (10/20/2015)
INSERT INTO Actor VALUES(3, 'Cooper', 'Bradley', 'male', 0, NULL);
# If Checks worked, it would violate the rule of being a valid date greater than 0.
# It would prevent the user from making this row.