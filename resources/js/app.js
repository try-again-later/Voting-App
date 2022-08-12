import "./bootstrap";

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
