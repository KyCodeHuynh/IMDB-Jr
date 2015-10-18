-- The names of all the actors in the movie
-- 'Die Another Day'.
SELECT DISTINCT first, last
FROM MovieActor AS MA, Actor AS A
WHERE MA.aid=A.id 
    AND mid=(SELECT id
                 FROM Movie
                 WHERE title='Die Another Day');

-- The count of all the actors who acted in
-- multiple movies. We get the set of all the 
-- actors who have been in multiple movies first.
SELECT COUNT(*)
FROM
    (SELECT aid
    FROM MovieActor
    GROUP BY aid
    HAVING COUNT(mid) > 1) AS tbl;


