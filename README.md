# About

This is a school project for subject Development of internet and intranet applications (VAII) at the Faculty of Management Science and Informatics of University of Žilina.
It aims to create a simple employee management system with a web interface. Allowing users to see their profile,
view and manage their attendances and absences. Admin can manage employees and see their statistics.

---

# Running in PhpStorm

If Docker Desktop (or Docker Engine) is running in the background, you do not need to run Docker from the command line — you can simply clone/open the GitHub repository in PhpStorm and start the project's Docker Compose from the IDE.
Go to `docker/docker-compose.yml` and next to services you will see 2 green arrows. Click the arrows and they will start the services.

Databases will be created automatically (`docker/sql/create_databases.sql`) upon running the docker services. Data for databases 
will be imported from `docker/sql/fill_databases.sql` file automatically as well.

---

# Website
The website is running on `http://localhost:8080/`. To see the admin panel, you can log in with the following credentials:
- Username: `admin`
- Password: `admin`

To see the employee panel, you need to log in with the users credentials in the `docker/sql/fill_databases.sql`. 
Each user has the same password as their username. For example, to log in as `employee1`, you would use:
- Username: `employee1`
- Password: `employee1`