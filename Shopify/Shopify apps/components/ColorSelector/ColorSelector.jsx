import React, {useCallback, useEffect, useMemo, useState} from "react";
import { Box, Button, ColorPicker, Popover, TextField } from "@shopify/polaris";
import { hexToHsb, hsbToHex } from "../helpers/index";

export const ColorSelector = ({ onColorChange, setColor: initialHex }) => {
  const [colorHsb, setColorHsb] = useState(() => hexToHsb(initialHex));
  const [popoverActive, setPopoverActive] = useState(false);

  const togglePopoverActive = useCallback(() => {
    setPopoverActive((active) => !active);
  }, []);

  const handleColorChange = (newColorHsb) => {
    setColorHsb(newColorHsb);
    if (onColorChange) {
      const newHex = hsbToHex(newColorHsb);
      onColorChange(newHex);
    }
  };

  const currentHex = useMemo(() => hsbToHex(colorHsb), [colorHsb]);

  useEffect(() => {
    setColorHsb(hexToHsb(initialHex));
  }, [initialHex]);

  const activatorStyle = {
    backgroundColor: currentHex,
    width: '52px',
    height: '24px',
    borderColor: 'black',
    borderWidth: '1px'
  };

  const activator = (
    <Button onClick={togglePopoverActive} variant="plain">
      <div style={activatorStyle}></div>
    </Button>
  );

  return (
    <Box position="relative">
      <TextField
        label="Select color"
        labelHidden
        value={currentHex}
        onChange={() => {}}
        autoComplete="off"
        readOnly
      />
      <Box height="28px" style={{top: "4px", right: "4px", position: "absolute", zIndex: "50"}}>
        <Popover
          active={popoverActive}
          activator={activator}
          autofocusTarget="none"
          onClose={togglePopoverActive}
        >
          <ColorPicker onChange={handleColorChange} color={colorHsb} />
        </Popover>
      </Box>
    </Box>
  );
};
