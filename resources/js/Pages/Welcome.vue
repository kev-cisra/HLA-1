<template>
    <div class="flex-container">
        <div class="flex-item-left fullHeight">
            <div id="carouselExampleDark" class="carousel carousel-dark slide carousel-fade fullHeight" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner fullHeight">
                    <div class="h-full carousel-item active" data-bs-interval="3500">
                    <img src="https://picsum.photos/200/300" class="d-block w-100 fullHeight" alt="...">
                    </div>
                    <div class="carousel-item fullHeight" data-bs-interval="3500">
                    <img src="https://picsum.photos/200/500" class="d-block w-100 fullHeight" alt="...">
                    </div>
                    <div class="carousel-item fullHeight" data-bs-interval="3500">
                    <img src="https://picsum.photos/200/400" class="d-block w-100 fullHeight" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="flex-item-right fullHeight">

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        }
    }
</script>
