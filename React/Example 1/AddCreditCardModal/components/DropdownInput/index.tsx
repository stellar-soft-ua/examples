import React, { memo, useCallback, useEffect, useMemo, useRef, useState } from 'react';
import clsx from 'clsx';
import { useDebounceSearch, useSearch } from 'hooks';
import { CountryState } from 'utils/countries';
import { CloseArrowIcon, OpenArrowIcon } from 'images/general/common';
import { DropdownMenu } from './components/DropdownMenu';
import styles from './styles.module.scss';

type Props = {
	options: Array<CountryState>;
	title: string;
	placeholder: string;
	hasCardInformation: boolean;
	error?: string;
	show?: boolean;
	onCardInformationClick: (value: string) => void;
};

export const DropdownInput = memo(
	({
		options,
		title,
		placeholder,
		hasCardInformation,
		error,
		show = true,
		onCardInformationClick,
	}: Props) => {
		const [selectedOption, setSelectedOption] = useState('');
		const [showDropdownMenu, setShowDropdownMenu] = useState(false);

		const { search, handleSearchChange, clearSearchValue } = useSearch();
		const debouncedSearchValue = useDebounceSearch(search.trim(), 300);

		const selectedOptionContainerRef = useRef<HTMLDivElement | null>(null);
		const filteredOptions = useMemo(() => {
			return options.filter((option) => {
				return option.name.toLowerCase().includes(debouncedSearchValue);
			});
		}, [options, debouncedSearchValue]);

		const selectedOptionTitle = selectedOption || placeholder;

		const selectedOptionContainerClass = clsx(
			styles.selectedOptionContainer,
			error && styles.selectedOptionWithError
		);
		const selectedOptionTitleClass = clsx(
			styles.initialTitle,
			selectedOption && styles.selectedOptionTitle
		);

		useEffect(() => {
			// clean state after submitting form
			if (!hasCardInformation) setSelectedOption('');
		}, [clearSearchValue, hasCardInformation]);

		const onToggleDropdownMenu = useCallback(() => {
			setShowDropdownMenu((prev) => !prev);
		}, []);

		const handleCloseDropdownMenu = useCallback(
			(event?: Event) => {
				if (selectedOptionContainerRef.current?.contains((event?.target as Node) || null))
					return;
				setShowDropdownMenu(false);
				clearSearchValue();
			},
			[clearSearchValue]
		);

		const handleOptionClick = useCallback(
			(option: string) => {
				if (option === selectedOption) return;
				setSelectedOption(option);
				onCardInformationClick(option);
				handleCloseDropdownMenu();
			},
			[handleCloseDropdownMenu, onCardInformationClick, selectedOption]
		);

		return show ? (
			<div className={styles.container}>
				<p className={styles.title}>{title}</p>
				<div
					className={selectedOptionContainerClass}
					ref={selectedOptionContainerRef}
					onClick={onToggleDropdownMenu}
				>
					<p className={selectedOptionTitleClass}>{selectedOptionTitle}</p>
					{showDropdownMenu ? <CloseArrowIcon /> : <OpenArrowIcon />}
				</div>
				{error && <p className={styles.error}>{error}</p>}
				<DropdownMenu
					show={showDropdownMenu}
					options={filteredOptions}
					selectedOption={selectedOption}
					searchValue={search}
					onOptionClick={handleOptionClick}
					onSearchChange={handleSearchChange}
					onClickOutside={handleCloseDropdownMenu}
				/>
			</div>
		) : null;
	}
);
