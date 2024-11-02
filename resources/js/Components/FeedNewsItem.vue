<template>
    <div class="box-content grid grid-cols-12 p-2 mb-2 rounded-md shadow-md cursor-pointer even:bg-slate-200">
        <div class="col-span-12 text-md">
            <slot name="title"></slot>
        </div>
        <div class="col-span-12 text-xs text-md">
            <div class="float-right mt-2 font-light">
                <slot name="pubDate"></slot>
            </div>
        </div>
    </div>
</template>
