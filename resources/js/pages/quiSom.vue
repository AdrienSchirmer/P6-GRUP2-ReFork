<script setup>

</script>

<template>
    <div class="h-dvh bg-[#F2FAFF] w-full gap-12 py-12 px-12 flex">
        <div class="px-4 py-3 flex flex-col gap-2 border border-gray-100 w-full rounded bg-white shadow-md">
            <h2 class="font-bold">¿Qui Som?</h2>
            <p>Som la Farmàcia Soler de Figueres, ens trobem a la Font lluminosa, Carrer Nou num. 22. Som una farmacia amb 80 anys d’història i amb més de 150 anys oberta. Actualment som la 3a generació.</p>
        </div>
        <img class="border border-gray-100 rounded h-full w-full object-cover shadow-md" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3rkdhjWypA8CeYtHvco3PIAlxFm3yIWR9Yw&s"/>
    </div>
    
    <!-- Footer -->
    <div class="h-dvh bg-[#151515] w-full py-12 px-12 flex flex-col gap-4">
        <!-- Above The Line -->
        <div class="flex justify-between">
            <img class="rounded h-48 w-[30%] object-cover shadow-md" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3rkdhjWypA8CeYtHvco3PIAlxFm3yIWR9Yw&s"/>
            <div class="flex flex-col text-white h-full justify-between">
                <div class="h-full flex gap-4">
                    <!-- Pagination -->
                    <div class="flex flex-col">
                        <h2 class="font-bold">Paginació</h2>
                        <a href="https://google.com">¿Quí Som?</a>
                        <a href="https://google.com">Contactan's</a>
                        <a href="https://google.com">Demanar Cita</a>
                    </div>
                    <!-- Legal -->
                    <div class="flex flex-col h-fit">
                        <h2 class="font-bold">Legal</h2>
                        <a href="https://google.com">Avís legal</a>
                        <a href="https://google.com">Política de privacitat</a>
                        <a href="https://google.com">Política de cookies</a>
                        <a href="https://google.com">Termes i condicions</a>
                    </div>
                </div>
                <!-- Social Media -->
                <div class="flex justify-end gap-3">
                    <p class="bg-white h-10 w-10 rounded-4xl text-black text-center flex flex-col justify-center">ig</p>
                    <p class="bg-white h-10 w-10 rounded-4xl text-black text-center flex flex-col justify-center">tk</p>
                    <p class="bg-white h-10 w-10 rounded-4xl text-black text-center flex flex-col justify-center">fb</p>
                </div>
            </div>
        </div>
        <!-- Line -->
        <div class="rounded-4xl p-0.5 bg-white"></div>
        <!-- Below The Line -->
        <div class="text-white h-2 w-full">
            <p>Copyright © 2026 Farmacia Soler</p>
        </div>
    </div>
</template>