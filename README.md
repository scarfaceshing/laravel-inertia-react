# LARAVEL + INERTIA + REACT

### Set up

```
git clone https://github.com/scarfaceshing/laravel-inertia-react.git
git clone https://github.com/Laradock/laradock.git
cd laravel-inertia-react
cp ./LARADOCK_ENV/.env.laravel-inertia-react ./../laradock/
npm run docker-up
```

### Enter workspace

```
npm run docker-exec
```

### Run project

```
composer install
npm run dev
```

### Fix code

```
npm run pre-commit
```

### Bypass pre-commit

```
rm -rvf ./husky/hooks
npm install
git add .
git commit -m "<commit>" --no-verify
git push
```

### Documentations

<div>https://www.luckymedia.dev/blog/laravel-breeze-with-inertia-react-eslint-prettier-pint-and-husky</div>
<div>https://laradock.io/</div>
