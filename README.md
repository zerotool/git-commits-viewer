# Git Commit Viewer

The goal is to show the last X commits skipping Y of them from Z GIT repository using:
* Command Line Interface
* Web API

## Setup

1. Install GIT and Docker.
2. GIT Clone into local directory:
```
git clone https://github.com/zerotool/git-commits-viewer.git
cd git-commits-viewer
```

### Command Line Tool
```
docker-compose exec php bash
php /app/yii git/log --help
php /app/yii git/log https://github.com/zerotool/chosen.git 10 0 short
```

### Web API:
```
docker-compose -d
```
Then `POST http://localhost:8082/commits/list`
JSON:
```
{
	"limit": 12,
	"offset": 34,
	"repositoryUrl": "https://github.com/zerotool/chosen.git"
}
```
All parameters are optional, max limit is 100.

Success response example:
```
{
    "elements": [
        {
            "hash": "db74a94595d5189ae7dec875301f5a3486d4e2e8",
            "dateTime": "2012-04-13T14:50:53-04:00",
            "email": "patrick@getharvest.com",
            "name": "Patrick Filler",
            "subject": "",
            "body": "Build is behind (how??). Re-build.\n",
            "stat": "\n chosen/chosen.jquery.js     | 2 +-\n chosen/chosen.jquery.min.js | 2 +-\n chosen/chosen.proto.js      | 2 +-\n chosen/chosen.proto.min.js  | 2 +-\n 4 files changed, 4 insertions(+), 4 deletions(-)\n\n"
        },
        {
            "hash": "c7619ea5b04391d82caf79ee160c72fa95950050",
            "dateTime": "2012-04-13T11:48:52-07:00",
            "email": "pf@patrickfiller.com",
            "name": "Patrick Filler",
            "subject": "Add -webkit-overflow-scrolling: touch for iOS5",
            "body": "Merge pull request #570 from kristerkari/master\n\nAdd -webkit-overflow-scrolling: touch for iOS5",
            "stat": ""
        }
    ]
}
```

Error response example:
```
{
    "errors": {
        "general": [
            "Failed to clone GIT repository"
        ]
    }
}
```

Parameter errors:
```
{
    "errors": {
        "limit": [
            "Limit must be less than or equal to \"100\"."
        ]
    }
}
```

## Testing

```
docker-compose exec php bash
cd /app
codecept run
```

## Architecture

The application consists of several components, divided into namespaces:
* `app\components\git` - everything related to GIT VCS operations and objects.
* `app\components\shell` - the functionality used to work with CLI interface in a resilient mode.
* `app\components\viewer` - classes to render the commits list for various clients (CLI, Web).

### Patterns used

#### Presenter `app\components\viewer\commit`
Consumer: `\app\models\CommitsListRequest`

Motivation: to support different render types for Web and CLI client requests

#### Singleton `\app\components\shell\Shell`

Consumer: `\app\components\shell\Command`

Motivation: to avoid creating an instance of Shell for each command

#### Repository `\app\components\shell\Commands\GitCommandsRepository`

Consumer: `\app\components\git\repository\storages\FolderStorage`

Motivation: to combine all GIT related Shell commands into one class to separate the responsibility

#### Command `\app\components\shell\Command`

Consumer: `Shell, GitCommandsRepository`

Motivation: to incapsulate the interaction with commands and their parameters

#### Dependency Injection `\app\components\git\Repository`

Consumer: `\app\models\CommitsListRequest`

Motivation: to get a more testable and extensible code we inject the Storage object to the Repository to support
multiple ways to store the repository data: Cloud, Folder, Persistent (DB), etc.

### Adding a new commit storage

1. Create a new class in `components/git/repository/storages` that implements `\app\components\git\repository\Storage`
abstract methods.
2. Use the new storage in `CommitsListRequest`. Currently `FolderStorage` is used.

### Adding a new commit viewer

1. Create a new class in `components/viewer/commit` extending `\app\components\viewer\Viewer`.
2. Use the new viewer to get commits in a different format:
```
echo $commitsListRequest->processUsingViewer(
    new FooViewer(FooViewer::BAR_FORMAT)
);
```

## Todo

1. Improve the test coverage (components).
2. Implement Persistent storage.
3. Add a request parameter to refresh the repository.
4. Decorate exceptions by adding more details.
5. Add a validation for a minimal required GIT version (support `--no-tags` parameter).
6. Add pagination support to GitHub API (limit, offset vs since, until).

## Contact Information

[st.erokhin@gmail.com](mailto:st.erokhin@gmail.com)

Copyright 2019 Stanislav Erokhin
