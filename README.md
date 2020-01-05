# CS-Cart Pull Request State Monitor

## Install

1. Clone the repository:
    ```bash
    $ git clone git@github.com:cscart/pr-monitor.git cscart-pr-monitor
    ```
1. Install dependencies:
    ```bash
    $ cd cscart-pr-monitor
    $ composer install
    ```

## Configure

The application requires the following environment variables to be set:

* `PR_MONITOR_APP_ENV` — runtime mode. Can be either `production` or `development`.
  
    In the `development` mode environment variables are loaded from the local `.env` file in the application directory.
  
    You can use `.env.example` file for the reference.
* `PR_MONITOR_GITHUB_LOGIN` — login of the user that will interact with Github API.
* `PR_MONITOR_GITHUB_ACCESS_TOKEN` — access token of the mentioned user.
* `PR_MONITOR_REPOSITORY_OWNER` — owner of the monitored repository.
* `PR_MONITOR_REPOSITORY` — name of the monitored repository.

    If you have the repository with the following URL: `https://github.com/example/example-repo`, then `example` is the owner and `example-repo` is the name.

* `PR_MONITOR_PR_MESSAGE` — text of the message that will be posted in the conflicting pull request.

The following variables can be set to debug the application:

* `PR_MONITOR_FORCE_PRS` — numbers of PRs to check. 

    Must a JSON-encoded array of numbers, e.g. `[1234,2345,5678]`. 

## Run

After the application is configured, you can run it with the following command:
```bash
php bin/pr-monitor
``` 

The application does the following with all the open pull requests in the repository:
1. Checks whether the pull request has merge conflicts.
1. Posts message "PR has conflicts" for the pull request with merge conflicts.
1. Sets status of the last commit in the unmergeable pull request to `error`.

The application outputs the following messages when working:

```
✅ https://github.com/example/example-repo/pull/1234 Pull request title.
```
— the pull request has no conflicts.

```
🛑 https://github.com/example/example-repo/pull/1234 Pull request title.
```
— the pull request has conflicts.

```
🛠 https://github.com/example/example-repo/pull/1234 Pull request title.
```
— the merge conflict has been reported for the pull request.
