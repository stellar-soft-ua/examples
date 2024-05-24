# Slide Panel Custom Element

## Purpose
The `Panel` custom element provides a way to create slide-in panels for various UI contexts. These panels can be toggled open and closed via specified triggers and can be aligned to the left, right, or center (as a popup).

## Key Features
- **Custom Attributes:** Supports custom attributes for default open state, alignment, additional classes, and context for event-based triggers.
- **Trigger Events:** Listens for open, close, and toggle events to manage the panel state.
- **Shadow DOM:** Encapsulates styles and markup.

## Attributes
- `default-open` (boolean): Specifies whether the panel is open by default. Accepted values are `true` or `false`.
- `alignment` (string): Specifies the alignment of the panel. Accepted values are `left`, `right`, or `popup`.
- `additionalClasses` (string): Additional CSS classes to apply to the panel.
- `context` (string): Context for event-based triggers.

## Example Usage
```html
<slide-panel
  default-open="false"
  alignment="right"
  additionalClasses="custom-class"
  context="example"
  openTriggerSelector="#openButton"
  closeTriggerSelector="#closeButton"
  toggleSelector="#toggleButton"
></slide-panel>

<button id="openButton">Open Panel</button>
<button id="closeButton">Close Panel</button>
<button id="toggleButton">Toggle Panel</button>
