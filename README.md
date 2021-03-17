<p align="center"><img src="https://orgusto.com/orgusto-logo-svg.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
</p>

## About Orgusto

Orgusto ist crap! 💩

Visit the [Beta](https://beta.orgusto.com)

## Development

### Code style

Code style rules are enforced with the help of `husky`, `lint-staged` and `prettier`. All project files are automatically checked and fixed before committing, making sure all complies to the code style defined in `.prettierrc`.

### Commits

This project uses [conventional commits](https://www.conventionalcommits.org/en/v1.0.0/) for both, better management and visibility and more meaningful commit messages. To use `conventional commits` _hazzle-free_, make sure to install this [VSCode Extension](https://marketplace.visualstudio.com/items?itemName=vivaxy.vscode-conventional-commits).

To commit your changes, use the vscode terminal to call the `Conventional Commits` command and follow the questionnaire to commit your changes to the repository. **Make sure to use [the conventions](https://www.conventionalcommits.org/en/v1.0.0/#specification) to create short and meaningful commit messages!**

### Tagging

To tag for a new release, use the builtin scripts to automatically create release tags while enforcing [semver](https://semver.org/lang/de/) and automatically create and update `CHANGELOG.md`. All credits to [standard-version](https://github.com/conventional-changelog/standard-version) for their awesome tool.

```sh
# Create new release for production channel (e.g. current version 0.1.0)
npm run release # -> 0.1.1
# Create new release for beta channel (e.g. current version 0.1.0)
npm run release:beta # -> 0.1.1-beta0
# Create new release and major, minor, patch, etc. (e.g. current version 0.1.0)
npm run release:as minor # -> 0.2.0
# Finally, push your changes (make sure to include tags)
git push --follow-tags
```

## License

tbd
