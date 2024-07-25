# Task manager

### This app is a pet project for managing user tasks

## Features in this application

> Registration \
> Login \
> Logout \
> See the list of all user tasks \
> Filter tasks based on status \
> Sort tasks by creation date \
> Navigate through the tasks using pagionation \
> Create new task + attach files \
> See details of a single task with all files sticked to it \
> Update task description and status \
> Delete task

### In this project it is allowed only to use libraries like Twig for templating and phpdotenv for storing env variables

### Task is implemented in MVC design pattern with custom Router, Model and Controller

### Tables short defintion:
> users: id first name last name email password \
> tasks: id, title, description, assigned user, date time of creation, date time of last update, status (one of these values: NEW, IN PROGRESS, REVIEW, DONE)
