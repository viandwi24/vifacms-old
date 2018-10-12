<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helpers\vcms;

class vcmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:vcms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install VCMS with Artisan Laravel Console.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('==============================================================');
        $this->info('===================[ VCMS INSTALLATION ]======================');
        $this->info('==============================================================');
        $this->info('');
        $this->info('===[1. Create Database.');
        $this->info('Konfigurasikan Database anda di .env, salin file .env.example');
        $this->info('lalu edit menjadi .env dan ubah konfigurasi didalamnya.');
        if ($this->confirm('Sudahkan Database Di Konfigurasi?')) {
            $this->installDB();
        } else {
            $this->cancelInstall();
        }
    }

    public function installDB()
    {
        $this->info('[-] Migrating...');
        $this->call('migrate:fresh');
        $this->info('');

            $this->info('================================================');
        $this->info('[-] Create Default Theme, Default Config.');
        $this->info('  [+] Create Default Config...');
        $app_address = $this->ask('Your Address?');
        vcms::setting()->create('app_address', $app_address);
        $app_author = $this->ask('Author Name?');
        vcms::setting()->create('app_author', $app_author);
        $app_description = $this->ask('Description For This Web?');
        vcms::setting()->create('app_description', $app_description);
        $app_email = $this->ask('Author Email?');
        vcms::setting()->create('app_email', $app_email);
        $app_title = $this->ask('Title For This Web?');
        vcms::setting()->create('app_title', $app_title);

        $this->info('  [+] Set Post Url Mode.');
        vcms::setting()->create('post_url', json_encode(['model'=>1]));

        $this->info('  [+] Create Default Theme...');
        $theme = new \App\Models\theme;
        $theme->name = 'BlogStrap';
        $theme->author = 'Vian Dwi Nugraha';
        $theme->version = '2.0.1';
        $theme->theme_home  = $this->getDefaultThemeHome();
        $theme->theme_post  = $this->getDefaultThemePost();
        $theme->theme_search  = '';
        $theme->theme_404 = '<h1>404</h1>';
        $theme->save();
        vcms::setting()->create('theme', 1);

        $this->info('');
            $this->info('================================================');
        $this->info('[+] Create Master Admin.');
        $this->createAdmin();
    }

    public function createAdmin()
    {
        $name = $this->ask('[Master Admin] : Your Full Name?');
        $email = $this->ask('[Master Admin] : Your email?');
        $password = $this->secret('[Master Admin] : Create Password :');
        $rePassword = $this->secret('[Master Admin] : Re-type Password :');

        if ($password != $rePassword)
        {
            $this->info('================================================');
            $this->error('Password and RePassword Wrong, Create Again...');
            $this->info('================================================');
            $this->createAdmin();
        } else {
            $this->info('[-] Creating Master Admin Account...');
            $user                       = new \App\user();
            $user->name                 = $name;
            $user->email                = $email;
            $user->email_verified_at    = now();
            $user->password             = bcrypt($password);
            $user->remember_token       = str_random(10);
            $user->save();
            $this->successInstall();
        }
    }

    public function cancelInstall()
    {
        $this->error('Installation Cancelled.');
    }
    public function successInstall()
    {
        $this->info('Installation Success.');
    }

    public function getDefaultThemeHome()
    {
        $home = <<<EOT
[:set.config.post-glue|<hr>:]
[:set.config.max-symbol|...:]
[:set.config.title-max|60:]
[:set.config.post-null|<center>Tidak Ada Postingan.</center>:]
[:set.config.category-null|Tidak ber-kategori.:]
[:set.config.pagination-limit|4:]
[:set.config.force-full-pagination|0:]

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>HOME | [:app.title:]</title>
  </head>
  <body>
    <div class="jumbotron" style="margin-bottom: 0;">
      <h1 class="display-4"> [:app.title:] </h1>
      <p class="lead"> [:app.description:] </p>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 25px;">
      <a class="navbar-brand" href="[:app.home.url:]"> [:app.title:] </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="[:app.home.url:]">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
    
    <div class="container" style="margin-bottom: 25px;">
      <div class="card">
        <div class="card-body">
          
          [:data.post.div.start:]
          <h3> [:post.title:] </h3>
          [:post.category|<span class="text-muted">[:post.category.text:]</span>|, :]
          <p> [:post.description:] </p>
          <a href="[:post.url:]"> Selengkapnya </a>
          [:data.post.div.end:]
          
          <hr>
          <center>
            <div aria-label="Page navigation example">
              <ul class="pagination">
                [:data.pagination.div.start:]
                
                  [:pagination.btn-previous.active.start:]
                  <li class="page-item"><a class="page-link" href="[:url:]">Previous</a></li>
                  [:pagination.btn-previous.active.end:]

                  [:pagination.btn-previous.disable.start:]
                  <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                  [:pagination.btn-previous.disable.end:]


                  [:pagination.btn-page.start:]
                  <li class="page-item"><a class="page-link" href="[:url:]">[:page:]</a></li>
                  [:pagination.btn-page.end:]

                  [:pagination.btn-page.active.start:]
                  <li class="page-item active">
                    <a class="page-link" href="#">[:page:] <span class="sr-only">(current)</span></a>
                  </li>
                  [:pagination.btn-page.active.end:]
                
                  [:pagination.btn-far.start:]
                  <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                  [:pagination.btn-far.end:]
                
                  [:pagination.btn-next.active.start:]
                  <li class="page-item"><a class="page-link" href="[:url:]">Next</a></li>
                  [:pagination.btn-next.active.end:]

                  [:pagination.btn-next.disable.start:]
                  <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                  [:pagination.btn-next.disable.end:]
                
                [:data.pagination.div.end:]
              </ul>
            </div>
          </center>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
EOT;
        return $home;
    }
    public function getDefaultThemePost()
    {
        $post = <<<EOT

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>[:post.title:] | [:app.title:]</title>
  </head>
  <body>
    <div class="jumbotron" style="margin-bottom: 0;">
      <h1 class="display-4"> [:app.title:] </h1>
      <p class="lead"> [:app.description:] </p>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 25px;">
      <a class="navbar-brand" href="[:app.home.url:]"> [:app.title:] </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="[:app.home.url:]">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
    
    <div class="container" style="margin-bottom: 25px;">
      <div class="card">
        <div class="card-body">
          <h2>[:post.title:]</h2>
          [:post.category|<span class="text-muted">[:post.category.text:]</span>|, :]
          <hr>
          [:post.article:]
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
EOT;
    
        return $post;
    }
}
