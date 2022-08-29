Project Instructions:

-After cloning the repository from git, run the following commands in cli of the project folder

composer install
npm install

-Import Database (given in the folder, named "kanban-to-do")

-set database credential in .env file

-Generate Key

php artisan key:generate

-now run the two commands 

php artisan ser
npm run watch




API Instructions

Get All Tasks:-

Routes:(GET)

http://127.0.0.1:8000/api/tasks


Store Task:-

Routes:(POST)

http://127.0.0.1:8000/api/tasks/store

Body:
{
    "user_id": "1",
    "title" : "Task Api"
}

Update Task:-

Routes:(POST)

http://127.0.0.1:8000/api/tasks/update

Body:
{
    "user_id": "1",
    "task_id": "1",
    "title" : "Task Updated"
}

Delete Task:-

Routes:(POST)

http://127.0.0.1:8000/api/tasks/destroy

Body:
{
    "task_id": "1"
}

Update Task Status:-

Routes:(POST)

http://127.0.0.1:8000/api/tasks/status-update

Body:
{
    "task_id": "1"
}

Update Task Priority:-

Routes:(POST)

http://127.0.0.1:8000/api/tasks/priority-update

Body:
{
    "task_id": "9",
    "priority" : "3"
}
