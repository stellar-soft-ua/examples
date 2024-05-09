<p align="center">
  <a href="http://nestjs.com/" target="blank"><img src="https://nestjs.com/img/logo-small.svg" width="200" alt="Nest Logo" /></a>
</p>

[circleci-image]: https://img.shields.io/circleci/build/github/nestjs/nest/master?token=abc123def456
[circleci-url]: https://circleci.com/gh/nestjs/nest

  <p align="center">A progressive <a href="http://nodejs.org" target="_blank">Node.js</a> framework for building efficient and scalable server-side applications.</p>
    <p align="center">
<a href="https://www.npmjs.com/~nestjscore" target="_blank"><img src="https://img.shields.io/npm/v/@nestjs/core.svg" alt="NPM Version" /></a>
<a href="https://www.npmjs.com/~nestjscore" target="_blank"><img src="https://img.shields.io/npm/l/@nestjs/core.svg" alt="Package License" /></a>
<a href="https://www.npmjs.com/~nestjscore" target="_blank"><img src="https://img.shields.io/npm/dm/@nestjs/common.svg" alt="NPM Downloads" /></a>
<a href="https://circleci.com/gh/nestjs/nest" target="_blank"><img src="https://img.shields.io/circleci/build/github/nestjs/nest/master" alt="CircleCI" /></a>
<a href="https://coveralls.io/github/nestjs/nest?branch=master" target="_blank"><img src="https://coveralls.io/repos/github/nestjs/nest/badge.svg?branch=master#9" alt="Coverage" /></a>
<a href="https://discord.gg/G7Qnnhy" target="_blank"><img src="https://img.shields.io/badge/discord-online-brightgreen.svg" alt="Discord"/></a>
<a href="https://opencollective.com/nest#backer" target="_blank"><img src="https://opencollective.com/nest/backers/badge.svg" alt="Backers on Open Collective" /></a>
<a href="https://opencollective.com/nest#sponsor" target="_blank"><img src="https://opencollective.com/nest/sponsors/badge.svg" alt="Sponsors on Open Collective" /></a>
  <a href="https://paypal.me/kamilmysliwiec" target="_blank"><img src="https://img.shields.io/badge/Donate-PayPal-ff3f59.svg"/></a>
    <a href="https://opencollective.com/nest#sponsor"  target="_blank"><img src="https://img.shields.io/badge/Support%20us-Open%20Collective-41B883.svg" alt="Support us"></a>
  <a href="https://twitter.com/nestframework" target="_blank"><img src="https://img.shields.io/twitter/follow/nestframework.svg?style=social&label=Follow"></a>
</p>
  <!--[![Backers on Open Collective](https://opencollective.com/nest/backers/badge.svg)](https://opencollective.com/nest#backer)
  [![Sponsors on Open Collective](https://opencollective.com/nest/sponsors/badge.svg)](https://opencollective.com/nest#sponsor)-->

## Description

[Nest](https://github.com/nestjs/nest) framework TypeScript starter repository.

## Installation

```bash
$ npm install
```

## Running the app

```bash
# development
$ npm run start

# watch mode
$ npm run start:dev

# production mode
$ npm run start:prod
```

## Test

```bash
# unit tests
$ npm run test

# test coverage
$ npm run test:cov
```

## License

Nest is [MIT licensed](LICENSE).


## Overview

This project implements a RESTful API for managing user data and avatar images. It includes endpoints for creating users, retrieving user data, fetching user avatars, and deleting user avatars. The project showcases skills in backend development, including API design, database integration, file system management, and event handling.

ESLint Compliance: The project passes ESLint checks to maintain code quality and consistency.

## Endpoints

### 1. POST /api/users

- **Description**: Creates a new user entry in the database.
- **Behavior**:
  - Upon receiving the request, the user entry is stored in the database.
  - After creation, a dummy email is sent and a rabbit event is emitted.
- **Note**: No consumer is required for handling email or rabbit event.

### 2. GET /api/user/{userId}

- **Description**: Retrieves user data in JSON representation.
- **Behavior**:
  - Retrieves user data from the external API [reqres.in](https://reqres.in/api/users/{userId}).
  - Returns the user data in JSON format.

### 3. GET /api/user/{userId}/avatar

- **Description**: Retrieves user avatar.
- **Behavior**:
  - On the first request, saves the image as a plain file and stores it in MongoDB with userId and hash.
  - Returns the base64-encoded representation of the image.
  - On subsequent requests, retrieves the previously saved image from the database and returns its base64-encoded representation.

### 4. DELETE /api/user/{userId}/avatar

- **Description**: Deletes the user avatar.
- **Behavior**:
  - Removes the file from the file system storage.
  - Deletes the stored entry from the database.
