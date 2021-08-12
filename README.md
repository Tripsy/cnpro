Setup & Run

    - git clone git@github.com:Tripsy/cnpro.git
    - navigate to project directory -> run "docker-compose up"
    - navigate to project directory -> run "composer update"

    App is set to run on domain "cnp.test".
    For Windows:
        Press the Windows key.
        Type Notepad in the search field.
        In the search results, right-click Notepad and select Run as administrator.
        From Notepad, open the following file: c:\Windows\System32\Drivers\etc\hosts
        Add modifications

            127.0.0.1       cnp.test

        Click File > Save to save your changes.


    Test

        http://cnp.test/?cnp=1910217410067