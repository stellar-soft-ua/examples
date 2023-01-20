import React, { memo } from 'react';
import { useTranslation } from 'react-i18next';
import { PrimaryButton } from 'components/common/desktop/PrimaryButton';
import styles from './styles.module.scss';

type Props = {
	disabled: boolean;
	loadingCard: boolean;
	onCancelClick: () => void;
	onSaveClick: () => void;
};

export const ActionButtons = memo(
	({ disabled, loadingCard, onCancelClick, onSaveClick }: Props) => {
		const { t } = useTranslation();

		return (
			<div className={styles.container}>
				<p className={styles.cancelButton} onClick={onCancelClick}>
					{t('billing_page_add_card_section_cancel_button')}
				</p>
				<PrimaryButton
					title={t('billing_page_add_card_section_save_button')}
					loading={loadingCard}
					disabled={disabled}
					className={styles.saveButton}
					onClick={onSaveClick}
				/>
			</div>
		);
	}
);
