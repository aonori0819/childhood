# childhood


## 1. What is 'childhood'?
This is a web application for recording small moments and events in your child’s life.
It allows parents to share and reflect on the joys (and sometimes the challenges) of raising a child together.

## 2. Technologies Used
  * Frontend
    * HTML
    * CSS
    * MDBootstrap
  
  * Backend
    * PHP 8.1.4
    * Laravel 9.6.0
    * MySQL 8.0.28
    * composer
    * PHPUnit
  
  * Inflastructure
    * nginx 1.20.2
    * Development Environment：Docker 20.10.12 / Docker Compose 3.9.0
    * Production Environment：AWS ( EC2, ALB, ACM, S3, RDS, Route53, VPC, IAM ) 
   
  * misc
    * GitHub
    * PHPMyAdmin
    * VScode 

## 3. Influstructure Diagram
<img src="https://user-images.githubusercontent.com/98136753/162661657-c7054649-fc8f-4166-b9b2-aa14b3521315.png" width="400px" alt="インフラ構成図" >



## 4. Entity-Relationship Diagram
![childhood_erd_03](https://user-images.githubusercontent.com/98136753/162660896-b1afc3ca-4e54-4c88-92b0-fa0f3b8686a8.svg)  



## 5. App Features
  This app is designed for sharing memories exclusively with invited family members.
All posts, viewing, and comments on memories are only accessible within the same family.
  

## 6. App Feature List
  * Authentication Features
    * User registration
    * Login and logout
    * Password reset

  * Main Features
    * Memory posting (CRUD functionality)
    * Uploading images for memories
    * Posting and deleting comments on memories

  * Reflection Features
    * Display of PickUp memories (randomly selected past memories)
    * Display of memories for each child
    * Display of memories by year and month
   
  * User Settings
    * Register username and profile picture
    * Register child’s name, profile picture, and date of birth
    * Set family name
    * Send family invitation email (using SendGrid)
