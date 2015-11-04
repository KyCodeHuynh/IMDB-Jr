# Project 1C
CS 143 | Fall 2015
Crystal Hsieh and Ky-Cuong Huynh
25 October 2015

## Explanation of the Project

[TODO: KY-CUONG PLEASE ADD THE DESCRIPTION OF THE PROJECT]

# Search Feature 
In creating the Search Feature, I made a hierarchy for how the queries are handled.
  For Movies:
     1) Look for a movie title in the EXACT wording of the query
     2) Look for a movie title containing the exact wording of the query
     3) Look for a movie title containing all the words in the query (but could be spread out, in a different order)
  
  For Actors/Actresses:
     1) If there is TWO words:
          a) Look for an exact first + last name pairing (either order)
          b) If nothing found, look for a first/last name pairing that starts with the query given
    
     2) If there's NOT TWO words (either 1, or >= 3):
          a) Pattern match for any first/last name that contains anything of what was queried 
          b) So if typing "Oprah" -- you would find "Oprah Winfrey"
          c) If typing "Win" -- you would find any value that has "Win" in the first or last name
          d) If typing anything greater than 3, we'll look for any pattern that matches all three, although its most likely improbable.. more for movie titles     

## Division of Labor 

Ky-Cuong handled the four input pages, so that a user could add new Movies/Actors/Comments/Relations. He also covered the overall CSS look of all the pages, using a framework called Foundation. Ky-Cuong also created half of the Selenium HTML tests.

Crystal handled the implementation of the two browsing pages (showActor.php and showMovie.php), as well as the search page. She also added some SQL logic for the input pages for the information to be transferred to the database. She also recorded the other half of the Selenium tests.

Both of us worked to test the project under our virtual machines, as well as error check for each other's work.

An aspect that we can improve as a team is to set specific deadlines for each other, planning in advance for the midterms and roadblocks that we might face. We were unable to evaluate our future schedules (with a total of four midterms for both of us this week) -- which caused us to be in a time crunch for the project.

## Additional Notes

We will be taking one "grace day" for Project 1C. 
