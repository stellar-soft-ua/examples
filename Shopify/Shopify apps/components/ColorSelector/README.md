# ColorSelector Component

## Purpose
The `ColorSelector` component is a React functional component that allows users to select a color using a color picker. It displays the selected color in a text field and a button that shows a color swatch. The component converts between hex and HSB color formats.

## Key Features
- **Color Picker:** Utilizes Shopify's Polaris `ColorPicker` for selecting colors.
- **Hex and HSB Conversion:** Converts colors between hex and HSB formats using helper functions.
- **Popover:** Uses Polaris `Popover` to show the color picker when the button is clicked.
- **State Management:** Manages the current color state and updates the parent component via the `onColorChange` callback.

## Props
- `onColorChange` (function): Callback function to handle color changes. Receives the selected color in hex format.
- `setColor` (string): Initial hex color value to set the color picker.

## Example Usage
```javascript
import React, { useState } from 'react';
import { ColorSelector } from './path/to/ColorSelector';

const ExampleComponent = () => {
  const [color, setColor] = useState('#ff0000');

  const handleColorChange = (newColor) => {
    setColor(newColor);
    console.log('Selected color:', newColor);
  };

  return (
    <div>
      <ColorSelector onColorChange={handleColorChange} setColor={color} />
      <p>Selected Color: {color}</p>
    </div>
  );
};

export default ExampleComponent;
