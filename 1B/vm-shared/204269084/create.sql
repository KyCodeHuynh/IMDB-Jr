CREATE TABLE Movie (
    id INT PRIMARY KEY, # Movie ID, must be present and unique - first primary key 
    title VARCHAR(100) NOT NULL, # Movie title - can't be null
    year INT,           # Release year
    rating VARCHAR(10), # MPAA rating
    company VARCHAR(50), # Production company
    CHECK(year > 1880 AND year < 2016) # Check Constraint (1): must be greater than the year 1880 (when movies were first made) 
                                       # Must be less than 2016, within a year of release from now
) ENGINE=INNODB; 


CREATE TABLE Actor (
    id INT PRIMARY KEY, # People ID, must be present and unique - second primary key
    last VARCHAR(20) NOT NULL,   # Last name 
    first VARCHAR(20) NOT NULL,  # First name 
    sex VARCHAR(6) NOT NULL,     # Actor's sex
    dob DATE,           # Date of birth
    dod DATE,            # Date of death
    CHECK(sex = "female" OR sex = "male"), # Check Constraint (2): must be either female or male
    CHECK(dob > 0 AND dob < 20151020) # Check Constraint (3): date of birth must be greater than 0
                                      # date of birth must also be before today's date, 10/20/2015
) ENGINE=INNODB;

CREATE TABLE Director (
    id INT PRIMARY KEY, # People ID, must be present and unique - third primary key
    last VARCHAR(20) NOT NULL,   # Last name 
    first VARCHAR(20) NOT NULL,  # First name 
    dob DATE,           # Date of birth
    dod DATE            # Date of death        
) ENGINE=INNODB;

CREATE TABLE MovieGenre (
    mid INT,            # Movie ID 
    genre VARCHAR(20),  # Movie genre
    FOREIGN KEY (mid) REFERENCES Movie(id)    # (1) foreign key for the movie genre to reference a Movie ID  
) ENGINE=INNODB;

CREATE TABLE MovieDirector (
    mid INT, # Movie ID 
    did INT, # Director ID
    FOREIGN KEY (mid) REFERENCES Movie(id),   # (2) foreign key to reference specific Movie ID to a director
    FOREIGN KEY (did) REFERENCES Director(id) # (3) foreign key to reference specific Director ID to a movie
) ENGINE=INNODB;

CREATE TABLE MovieActor (
    mid INT, # Movie ID
    aid INT, # Actor ID 
    role VARCHAR(50), # Actor's role
    FOREIGN KEY (mid) REFERENCES Movie(id),   # (4) foreign key to reference specific Movie ID the actor was in
    FOREIGN KEY (aid) REFERENCES Actor(id)    # (5) foreign key to reference specific Actor who acted
) ENGINE=INNODB;

CREATE TABLE Review (
    name VARCHAR(20),     # Reviewer's name
    time TIMESTAMP,       # Timestamp of review
    mid INT REFERENCES Movie(id), # Movie reviewed 
    rating INT,           # Movie rating
    comment VARCHAR(500), # Reviewer's comment
    FOREIGN KEY (mid) REFERENCES Movie(id)     # (6) foreign key to reference Movie ID reviewed
) ENGINE=INNODB;

CREATE TABLE MaxPersonID (
    id INT # The largest ID assigned to a person so far
) ENGINE=INNODB;

CREATE TABLE MaxMovieID (
    id INT # The largest ID assigned to a movie so far
) ENGINE=INNODB;



