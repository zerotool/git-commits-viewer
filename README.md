# Git Commit Viewer

Goal is to show last X commits skipping Y of them from Z GIT repository by:
* Command Line Interface
* Web API

## Setup

1. Install GIT and Docker.
2. GIT Clone into local directory.

### Command Line Tool
```
docker-compose exec php bash
php /app/yii git/log --help
php /app/yii git/log https://github.com/...git 10 0 short
```

### Web API:
```
docker-compose -d
```
Then POST http://localhost:8082/commits/list
JSON:
```
{
	"limit": 12,
	"offset": 34,
	"repositoryUrl": "http://github.com/..."
}
```

## Testing

```
docker-compose exec php bash
cd /app
codecept run
```

## Architecture

Patterns used:
* Presenter
* Singleton
* Repository

### Adding new commits storage

### Adding new commits viewer

## Todo

1. Add test coverage
2. 

## Contact Information

st.erokhin@gmail.com

Copyright 2019 Stanislav Erokhin
