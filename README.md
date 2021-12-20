<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Interfell Test

### Problem 1: Chess Prediction

You have a square chess board with one queen and a number of obstacles placed on it.
Determine how many squares the queen can attack.
A queen is standing on an n x n chessboard. The chess board's rows are numbered from 1
to n, going from bottom to top. Its columns are numbered from 1 to n, going from left to right.
Each square is referenced by a tuple, (r, c) , describing the row, r, and column, c, where the
square is located .

#### Documentation for testing:

Command for running the laravel app: php artisan serve

Route: http://localhost:8000/api/problem-1

Type: POST 

Example of Parameter to be sent:

{

  "input": {

​    "n": 5,

​    "k": 4, 

​    "rq": 4, 

​    "cq": 4,

​    "obstacles": [[5,1], [5,2], [3,3], [4,3]]

  }  

}

\- n: an integer, the number of rows and columns in the board
\- k: an integer, the number of obstacles on the board
\- rq: integer, the row number of the queen's position
\- cq: integer, the column number of the queen's position
\- obstacles: a two dimensional array of integers where each element is an array of integers,
the row and column of an obstacle.



All of these fields has to be sent inside a parameter called "input"



#### Problem 2: String value

Jane loves strings more than anything. She has a string t with her, and value of string s over
function f can be calculated as given below:

**f(s) = |s| x Number of times s occurs in t**  

#### Documentation for testing:

*Command for running the laravel app:* php artisan serve

*Route:* http://localhost:8000/api/problem-2

*Type:* POST 

**Example of Parameter to be sent:**

*t:* 'abcabcddd'

The 't' parameter must be a string of lowercase English alphabets.  

