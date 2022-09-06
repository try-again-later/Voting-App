import "./bootstrap";

// https://livewire.laravel.com/docs/upgrading#accessing-alpine-via-js-bundle
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

import nProgress from "nprogress";
import 'nprogress/nprogress.css';

import {
    computePosition,
    flip,
    shift,
    offset,
    autoUpdate as floatingAutoUpdate,
} from "@floating-ui/dom";

function updateWindowPosition(button, floatingWindow) {
    computePosition(button, floatingWindow, {
        middleware: [
            offset(8),
            shift({ padding: 16 }),
            flip({ fallbackStrategy: "initialPlacement" }),
        ],
        placement: "bottom-start",
    }).then(({ x, y }) => {
        Object.assign(floatingWindow.style, {
            left: `${x}px`,
            top: `${y}px`,
        });
    });
}

window.updateWindowPosition = updateWindowPosition;
window.floatingAutoUpdate = floatingAutoUpdate;

Livewire.start();

let sentMessagesCount = 0;
let nProgressRunning = false;

Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
    sentMessagesCount += 1;
    if (sentMessagesCount > 0 && !nProgressRunning) {
        nProgress.start();
        nProgressRunning = true;
    }

    succeed(({ snapshot, effects }) => {
        // Equivalent of 'message.sent'
        // Equivalent of 'message.received'

        queueMicrotask(() => {
            // Equivalent of 'message.processed'
            sentMessagesCount -= 1;
            if (sentMessagesCount <= 0 && nProgressRunning) {
                nProgress.done();
                nProgressRunning = false;
            }
        })
    });

    fail(() => {
        // Equivalent of 'message.failed'
        sentMessagesCount -= 1;
        if (sentMessagesCount <= 0 && nProgressRunning) {
            nProgress.done();
            nProgressRunning = false;
        }
    });
})
