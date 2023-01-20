import React, { memo, useCallback } from 'react';
import {
	AMEX_TYPE,
	MASTERCARD_TYPE,
	UNION_PAY_TYPE,
	VISA_TYPE,
} from '../../../../../../helpers';
import { AmexIcon, MasterCardIcon, UnionPayIcon, VisaIcon } from 'images/general/common';
import styles from './styles.module.scss';

type Props = {
	cardType: string;
};

export const CardIcon = memo(({ cardType }: Props) => {
	const renderIcon = useCallback(() => {
		switch (cardType) {
			case VISA_TYPE:
				return <VisaIcon className={styles.icon} />;

			case MASTERCARD_TYPE:
				return <MasterCardIcon className={styles.icon} />;

			case AMEX_TYPE:
				return <AmexIcon className={styles.icon} />;

			case UNION_PAY_TYPE:
				return <UnionPayIcon className={styles.icon} />;

			default:
				return <></>;
		}
	}, [cardType]);

	return renderIcon();
});
