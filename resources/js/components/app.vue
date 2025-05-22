<template>
    <h1>Hello System</h1>
    <p>
        <strong>Current route path:</strong>{{ $route.path }}
    </p>
    <nav>
        <div>
            <router-link class="link" to="/">Home</router-link>
            <router-link class="link" to="/destination">Destination</router-link>
        </div>
    </nav>
    <main>
        <router-view/>
    </main>
</template>