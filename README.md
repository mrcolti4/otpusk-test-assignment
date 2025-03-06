## Installation

Follow these steps to get the project up and running:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/mrcolti4/otpusk-test-assignment.git
    cd otpusk-test-assignmen
    ```

2. **Install dependencies:**

    Use Composer to install the required dependencies:

    ```bash
    composer install
    ```
3. **Create db file and run migrations**
   
    For this task was used sqlite.

    ```bash
    touch var/data.db
    php bin/console doctrine:migrations:migrate
    ```
4. Run php server

   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

   Open in browser [http://127.0.0.1:8000/admin/links](http://127.0.0.1:8000/admin/links)
