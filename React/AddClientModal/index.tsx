import { useTranslation } from 'react-i18next'
import { RiCloseFill } from 'react-icons/ri'
import Label, { labelTypes } from '../../../shared/components/atoms/label'
import { useGlobalModalContext } from '../../../shared/components/organismes/GlobalModal';
import { Container } from './styles'
import { AddClientModalProps } from './types'
import { AddClientForm } from './AddClientForm'

export const AddClientModal = ({ fetchClients }: AddClientModalProps) => {
  const [t] = useTranslation('common');
	const { hideModal } = useGlobalModalContext();

  return (
    <Container>
      <RiCloseFill
        className="self-end w-[30px] h-[30px] absolute top-[32px] right-[32px] cursor-pointer"
        onClick={hideModal}
      />
      <Label type={labelTypes.BODY_XL} text={t('CLIENTS.ADD_CLIENT')} />
      <AddClientForm fetchClients={fetchClients} />
    </Container>
  )
}
