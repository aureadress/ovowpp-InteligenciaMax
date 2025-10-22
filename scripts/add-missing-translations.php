#!/usr/bin/env php
<?php

/**
 * Script para adicionar traduções faltantes ao pt_BR.json
 */

echo "🌐 Adicionando traduções faltantes ao pt_BR.json...\n\n";

$projectRoot = dirname(__DIR__);
$translationFile = $projectRoot . '/resources/lang/pt_BR.json';
$missingKeysFile = $projectRoot . '/storage/logs/missing-keys.json';

// Carregar traduções existentes
$existingTranslations = json_decode(file_get_contents($translationFile), true) ?? [];
echo "✅ Carregadas " . count($existingTranslations) . " traduções existentes\n";

// Carregar chaves faltantes
$missingKeys = json_decode(file_get_contents($missingKeysFile), true) ?? [];
echo "📝 Encontradas " . count($missingKeys) . " chaves faltantes\n\n";

// Traduções manuais para as chaves mais importantes
$manualTranslations = [
    "Unlimited" => "Ilimitado",
    "Not Available" => "Não Disponível",
    "Active" => "Ativo",
    "Inactive" => "Inativo",
    "Succeed" => "Sucesso",
    "Answered" => "Respondido",
    "Customer Reply" => "Resposta do Cliente",
    "Closed" => "Fechado",
    "Verified" => "Verificado",
    "Not Verified" => "Não Verificado",
    "Are you sure to enable this AI assistant?" => "Tem certeza que deseja ativar este assistente de IA?",
    "Are you sure to disable this AI assistant?" => "Tem certeza que deseja desativar este assistente de IA?",
    "Configure AI Assistant" => "Configurar Assistente de IA",
    "For further information, please refer to the official documentation." => "Para mais informações, consulte a documentação oficial.",
    "times" => "vezes",
    "Enter fixed amount" => "Digite o valor fixo",
    "Enter percentage amount" => "Digite o valor percentual",
    "System Setting > SEO Configuration" => "Configuração do Sistema > Configuração de SEO",
    "This manual gateway currency is " => "A moeda deste gateway manual é ",
    "AI Assistance" => "Assistência de IA",
    "CTA URL Message" => "Mensagem de URL CTA",
    "EMBEDDED SIGN UP CONFIGURATION" => "CONFIGURAÇÃO DE INSCRIÇÃO INCORPORADA",
    "Go to " => "Vá para ",
    "Now go to the " => "Agora vá para ",
    " Google Play Developer Reporting API" => " API de Relatórios do Google Play Developer",
    " page and click on the enable button" => " e clique no botão ativar",
    "Go to the " => "Vá para ",
    "Note: Changes may take up to 24 hours to take effect. However, there is an alternative method to expedite the process. Visit this " => "Nota: As alterações podem levar até 24 horas para entrar em vigor. No entanto, existe um método alternativo para acelerar o processo. Visite este ",
    "Documentations" => "Documentações",
    "Go to Facebook Login > Settings and add callback URL here" => "Vá para Login do Facebook > Configurações e adicione a URL de callback aqui",
    "Go to Setting > Basic and copy the credentials and paste to admin panel" => "Vá para Configurações > Básico e copie as credenciais para o painel admin",
    "Click on Sign In with Linkedin > Request access" => "Clique em Entrar com Linkedin > Solicitar acesso",
    "Email will be sent again with a" => "O e-mail será enviado novamente com um",
    " second delay. Avoid closing or refreshing the browser." => " segundo de atraso. Evite fechar ou atualizar o navegador.",
    "You can upload up to 5 files with a maximum size of " => "Você pode enviar até 5 arquivos com tamanho máximo de ",
    "\$viaText will be sent again with a" => "\$viaText será enviado novamente com um",
    "This method supports " => "Este método suporta ",
    "The transaction limits range from " => "Os limites de transação variam de ",
    "Are you sure to enable this \$title" => "Tem certeza que deseja ativar este \$title",
    "Are you sure to disable this \$title" => "Tem certeza que deseja desativar este \$title",
    "Type: " => "Tipo: ",
    "Width: " => "Largura: ",
    "Carousel Template" => "Modelo Carrossel",
    "AI Assistant" => "Assistente de IA",
    "Manage CTA URL" => "Gerenciar URL CTA",
    "Create URL" => "Criar URL",
    "CTA URl List" => "Lista de URLs CTA",
    "Important Note" => "Nota Importante",
    "The system prompt acts as the data source for the AI about your business information. Make it brief and clear." => "O prompt do sistema atua como fonte de dados para a IA sobre as informações do seu negócio. Mantenha-o breve e claro.",
    "The clearer and more specific your system prompt is, the more accurate the AI responses will be." => "Quanto mais claro e específico for seu prompt do sistema, mais precisas serão as respostas da IA.",
    "The fallback response will be sent to the customer when the AI cannot find a related response from the business information (system prompt)." => "A resposta de fallback será enviada ao cliente quando a IA não encontrar uma resposta relacionada nas informações do negócio (prompt do sistema).",
    "The AI will respond to the customer until a fallback response is triggered within 24 hours." => "A IA responderá ao cliente até que uma resposta de fallback seja acionada em até 24 horas.",
    "Avoid including sensitive or confidential information except business contact information in the system prompt, as it will be visible to the AI for generating replies." => "Evite incluir informações sensíveis ou confidenciais, exceto informações de contato comercial, no prompt do sistema, pois será visível para a IA ao gerar respostas.",
    "For an e-commerce business, include relevant product information in the system prompt,so that AI can generate relevant responses." => "Para um negócio de e-commerce, inclua informações relevantes sobre produtos no prompt do sistema, para que a IA possa gerar respostas relevantes.",
    "If there is any chatbot or the welcome message triggered, the AI will not respond to the customer." => "Se houver qualquer chatbot ou mensagem de boas-vindas acionada, a IA não responderá ao cliente.",
    "For an example of a system prompt, you can use the following" => "Para um exemplo de prompt do sistema, você pode usar o seguinte",
    "See Example" => "Ver Exemplo",
    "Notice" => "Aviso",
    "No AI Assistant has been configured for this system by the platform administrator. Please" => "Nenhum Assistente de IA foi configurado para este sistema pelo administrador da plataforma. Por favor",
    "contact administrator" => "contate o administrador",
    "to get it set up." => "para configurá-lo.",
    "Setup your AI Assistant and get personalized responses." => "Configure seu Assistente de IA e obtenha respostas personalizadas.",
    "Save Settings" => "Salvar Configurações",
    "System Prompt" => "Prompt do Sistema",
    "Please provide very clear details about your business. If possible, also include some initial product details so the AI can better reply on your behalf." => "Por favor, forneça detalhes muito claros sobre seu negócio. Se possível, inclua também alguns detalhes iniciais dos produtos para que a IA possa responder melhor em seu nome.",
    "Fallback Response" => "Resposta de Fallback",
    "If the customer query does not match the system prompt, this response will be sent instead." => "Se a consulta do cliente não corresponder ao prompt do sistema, esta resposta será enviada.",
    "Max Length" => "Comprimento Máximo",
    "E-commerce" => "E-commerce",
    "Service Business" => "Negócio de Serviços",
    "Real Estate" => "Imobiliária",
    "Modify the info below with your business details:" => "Modifique as informações abaixo com os detalhes do seu negócio:",
    "Copied to clipboard" => "Copiado para área de transferência",
    "Send me more" => "Envie-me mais",
    "Shop" => "Loja",
    "Export Report" => "Exportar Relatório",
    "Minimal" => "Mínimo",
    "Maximal" => "Máximo",
    "By specifying a contact list, all imported contacts will be added to the selected list. If left global, the contacts will not be added to any contact list." => "Ao especificar uma lista de contatos, todos os contatos importados serão adicionados à lista selecionada. Se deixado como global, os contatos não serão adicionados a nenhuma lista.",
    "Global" => "Global",
    "CTA URL Information" => "Informações da URL CTA",
    "The header can be Image or Text.The maximum text length is 60 characters." => "O cabeçalho pode ser Imagem ou Texto. O comprimento máximo do texto é de 60 caracteres.",
    "Body text will be hyperlinked to the website URL automatically. Maximum text length is 1024 characters." => "O texto do corpo será vinculado automaticamente à URL do site. O comprimento máximo do texto é de 1024 caracteres.",
    "Button text can be contained a maximum of 20 characters." => "O texto do botão pode conter no máximo 20 caracteres.",
    "Creating a user-friendly CTA URL is an excellent way to communicate with customers and prospects." => "Criar uma URL CTA amigável é uma excelente maneira de se comunicar com clientes e prospects.",
    "Save CTA URL" => "Salvar URL CTA",
    "CTA URL Name" => "Nome da URL CTA",
    "Enter a unique name" => "Digite um nome único",
    "Please enter a valid URL that will be used to redirect customers after clicking on the button." => "Por favor, insira uma URL válida que será usada para redirecionar clientes após clicar no botão.",
];

// Mesclar traduções
$newTranslations = [];
$addedCount = 0;

foreach ($missingKeys as $key => $value) {
    if (isset($manualTranslations[$key])) {
        $newTranslations[$key] = $manualTranslations[$key];
        $addedCount++;
        echo "✅ Adicionada: \"$key\" => \"" . $manualTranslations[$key] . "\"\n";
    } else {
        // Usar a chave em inglês como fallback
        $newTranslations[$key] = $key;
        echo "⚠️  Usando fallback: \"$key\"\n";
    }
}

// Mesclar com as traduções existentes
$allTranslations = array_merge($existingTranslations, $newTranslations);

// Ordenar por chave
ksort($allTranslations);

// Salvar arquivo atualizado
$jsonContent = json_encode($allTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($translationFile, $jsonContent);

echo "\n✅ Arquivo pt_BR.json atualizado!\n";
echo "📊 Total de traduções: " . count($allTranslations) . "\n";
echo "➕ Traduções adicionadas: " . count($newTranslations) . "\n";
echo "✅ Traduções manuais aplicadas: $addedCount\n";
echo "⚠️  Traduções usando fallback: " . (count($newTranslations) - $addedCount) . "\n";

// Validar JSON
$test = json_decode(file_get_contents($translationFile), true);
if ($test === null) {
    echo "\n❌ ERRO: JSON inválido!\n";
    exit(1);
}

echo "\n✅ JSON validado com sucesso!\n";
