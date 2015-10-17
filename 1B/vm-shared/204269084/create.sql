CREATE TABLE Movie (
    id INT PRIMARY KEY, # Movie ID
    title VARCHAR(100), # Movie title
    year INT,           # Release year
    rating VARCHAR(10), # MPAA rating
    company VARCHAR(50) # Production company
); 

CREATE TABLE Actor (
    id INT PRIMARY KEY, # People ID
    last VARCHAR(20),   # Last name 
    first VARCHAR(20),  # First name 
    sex VARCHAR(6),     # Actor's sex
    dob DATE,           # Date of birth
    dod DATE            # Date of death           
);

CREATE TABLE Director (
    id INT PRIMARY KEY, # People ID
    last VARCHAR(20),   # Last name 
    first VARCHAR(20),  # First name 
    dob DATE,           # Date of birth
    dod DATE            # Date of death        
);

CREATE TABLE MovieGenre (
    mid INT REFERENCES Movie(id), # Movie ID
    genre VARCHAR(20)             # Movie genre
);

CREATE TABLE MovieDirector (
    mid INT REFERENCES Movie(id),   # Movie ID
    did INT REFERENCES Director(id) # Director ID
);

CREATE TABLE MovieActor (
    mid INT REFERENCES Movie(id), # Movie ID
    aid INT REFERENCES Actor(id), # Actor ID
    role VARCHAR(50)              # Actor's role
);

CREATE TABLE Review (
    name VARCHAR(20),    # Reviewer's name
    time TIMESTAMP,      # Timestamp of review
    mid INT REFERENCES Movie(id), # Movie reviewed
    rating INT,          # Movie rating
    comment VARCHAR(500) # Reviewer's comment
);

CREATE TABLE MaxPersonID (
    id INT # The largest ID assigned to a person so far
);

CREATE TABLE MaxMovieID (
    id INT # The largest ID assigned to a movie so far
);



