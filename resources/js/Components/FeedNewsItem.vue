<template>
    <div class="box-content grid grid-cols-12 px-4 py-2 mb-2 rounded-md shadow-md cursor-pointer even:bg-slate-200">
        <div class="col-span-12 text-sm">
            <slot name="title"></slot>
        </div>
        <div class="col-span-12">
            <div class="float-right mt-2 text-sm font-light">
                <slot name="pubDate"></slot>
            </div>
        </div>
    </div>
</template>
