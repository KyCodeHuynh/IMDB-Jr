CREATE TABLE Movie (
    id INT PRIMARY KEY, # Movie ID, must be present and unique - first primary key 
    title VARCHAR(100) NOT NULL, # Movie title - can't be null
    year INT,           # Release year
    rating VARCHAR(10), # MPAA rating
    company VARCHAR(50), # Production company
    CHECK(year > 1880 AND year < 2016) # Check Constraint (1): must be greater than the year 1880 (when movies were first made) 
                                       # Must be less than 2016, within a year of release from now
); 


CREATE TABLE Actor (
    id INT PRIMARY KEY, # People ID, must be present and unique - second primary key
    last VARCHAR(20) NOT NULL,   # Last name 
    first VARCHAR(20) NOT NULL,  # First name 
    sex VARCHAR(6) NOT NULL,     # Actor's sex
    dob DATE,           # Date of birth
    dod DATE,            # Date of death
    CHECK(sex = "female" OR sex = "male"), # Check Constraint (2): must be either female or male
    CHECK(dob <= '2015-10-20') # Check Constraint (3): date of birth must be older than this code
);

CREATE TABLE Director (
    id INT PRIMARY KEY, # People ID, must be present and unique - third primary key
    last VARCHAR(20) NOT NULL,   # Last name 
    first VARCHAR(20) NOT NULL,  # First name 
    dob DATE,           # Date of birth
    dod DATE            # Date of death        
);

CREATE TABLE MovieGenre (
    mid INT REFERENCES Movie(id), # Movie ID - (1) foreign key to reference Movie
    genre VARCHAR(20)             # Movie genre
);

CREATE TABLE MovieDirector (
    mid INT REFERENCES Movie(id),   # Movie ID - (2) foreign key to reference Movie
    did INT REFERENCES Director(id) # Director ID - (3) foreign key to reference Director
);

CREATE TABLE MovieActor (
    mid INT REFERENCES Movie(id), # Movie ID - (4) foreign key to reference Movie
    aid INT REFERENCES Actor(id), # Actor ID - (5) foreign key to reference Actor
    role VARCHAR(50)              # Actor's role
);

CREATE TABLE Review (
    name VARCHAR(20),    # Reviewer's name
    time TIMESTAMP,      # Timestamp of review
    mid INT REFERENCES Movie(id), # Movie reviewed - (6) foreign key to reference Movie
    rating INT,          # Movie rating
    comment VARCHAR(500) # Reviewer's comment
);

CREATE TABLE MaxPersonID (
    id INT # The largest ID assigned to a person so far
);

CREATE TABLE MaxMovieID (
    id INT # The largest ID assigned to a movie so far
);



