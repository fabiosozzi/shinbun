<template>
    <div>
        <div class="grid grid-cols-12 mb-2 border-b-2 cursor-pointer">
            <div class="col-span-2 text-xs">
                <slot name="pubDate"></slot>
            </div>
            <div class="col-span-8 text-md">
                <slot name="title"></slot>
            </div>
            
            
        </div>
    </div>
</template>
