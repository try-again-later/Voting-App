import "./bootstrap";

import Alpine from "alpinejs";
import { computePosition, flip, shift, offset } from "@floating-ui/dom";

window.Alpine = Alpine;

function updateWindowPosition(button, floatingWindow) {
    computePosition(button, floatingWindow, {
        middleware: [offset(8), flip({fallbackStrategy: 'initialPlacement'}), shift({padding: 16})],
        placement: 'bottom-start'
    }).then(({ x, y }) => {
        Object.assign(floatingWindow.style, {
            left: `${x}px`,
            top: `${y}px`,
        });
    });
}

window.updateWindowPosition = updateWindowPosition;
Alpine.start();
